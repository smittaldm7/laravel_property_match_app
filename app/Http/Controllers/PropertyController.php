<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Property;
use App\PropertyRequirementMatch;
use App\Requirement;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('properties.create');
        //echo "create prop";exit;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    
    public function store(Request $request)
    {
        $property = new Property();
        $property->latitude = $request->get('latitude');
        $property->longitude = $request->get('longitude');
        $property->price = $request->get('price');
        $property->bedrooms = $request->get('bedrooms');
        $property->bathrooms = $request->get('bathrooms');

        
        $property->save();
        //exit;

        $requirements = Requirement::all();

        foreach($requirements as $requirement)
        {

            $distance_match_percent=0;
            //1. distance
            $distance = $this->distance($property->latitude, $property->longitude, 
                                    $requirement->latitude,$requirement->longitude, 'M');

            $max_full=2;
            $max_valid =10;
            if ($this->between($distance,0,$max_valid))
            {
                if ($this->between($distance,0,$max_full))
                {
                    $distance_match_percent=100;
                }
                else
                    //distance betwwen 2 and 10 miles ie max_full and max valid
                {

                    $distance_match_percent= 40 + (
                            
                                ( ($max_valid - $max_full) - ($distance -$max_full) )*60
                                / ($max_valid - $max_full)
                            );
                }
            }
            else 
            {
                $distance_match_percent=0;
            }

            //2. price and budget
            $price_match_percent=0;

            //if only max budget is specified for requirement
            if(is_null($requirement->min_budget))
            {
                //echo "min budget is null";
                $min_valid = $requirement->max_budget * 75 / 100;
                $min_full = $requirement->max_budget * 90 / 100;

                if($this->between($property->price, $min_valid, $requirement->max_budget))  
                {
                    if($this->between($property->price, $min_full, $requirement->max_budget))
                    {
                        $price_match_percent=100;
                    }
                    else//between min_valid and min_full
                    {
                        //calculate match percentage
                        $price_match_percent= 40+
                            (abs($property->price - $min_valid)/($requirement->max_budget - $min_valid)) * 60;
                    }
                }
                else
                {
                    $price_match_percent=0;
                }
            }  
            //if only min budget is specified for requirement
            else if(is_null($requirement->max_budget))
            {
                //echo "max budget is null";
                
                $max_valid = $requirement->min_budget * 125 / 100;
                $max_full = $requirement->min_budget * 110 / 100;

                if($this->between($property->price, $requirement->min_budget, $max_valid))  
                {
                    if($this->between($property->price, $requirement->min_budget, $max_full))
                    {
                        $price_match_percent=100;
                    }
                    else//between max_full and max valid
                    {
                        //calculate match percentage
                        $price_match_percent= 40+
                            (abs($max_valid - $property->price)/($max_valid - $requirement->min_budget)) * 60;
                    }
                }
                else
                {
                    $price_match_percent=0;
                }
            }
            //if both min and max budget are specified
            else
            {
                //echo "both budgets are specified";
                if($this->between($property->price, $requirement->min_budget, $requirement->max_budget))  
                {
                    $price_match_percent =100;
                }
                else
                {
                    $price_match_percent =0;   
                }
            }

            //3. bedrooms
            // only max bedrooms specified for requirement
            $bedroom_match_percent=0;
            if(is_null($requirement->min_bedrooms))
            {
                $min_valid = $requirement->max_bedrooms -5;
                $min_full = $requirement->max_bedrooms -2;

                if($this->between($property->bedrooms, $min_valid, $requirement->max_bedrooms))  
                {
                    if($this->between($property->bedrooms, $min_full, $requirement->max_bedrooms))
                    {
                        $bedroom_match_percent=100;
                    }
                    else//between min_valid and min_full
                    {
                        //calculate match percentage
                        $bedroom_match_percent= 40+
                            (($property->bedrooms - $min_valid)/($min_full - $min_valid)) * 60;
                    }
                }
                else
                {
                    $bedroom_match_percent=0;
                }
            }
            // only min bedrooms specified for requirement
            else if(is_null($requirement->max_bedrooms))
            {
                $max_valid = $requirement->min_bedrooms + 5;
                $max_full = $requirement->min_bedrooms +2;

                if($this->between($property->bedrooms, $requirement->min_bedrooms, $max_valid))  
                {
                    if($this->between($property->bedrooms, $requirement->min_bedrooms, $max_full))
                    {
                        $bedroom_match_percent=100;
                    }
                    else//between max_full and max valid
                    {
                        //calculate match percentage
                        $bedroom_match_percent= 40+
                            (($max_valid - $property->bedrooms)/($max_valid - $max_full)) * 60;
                    }
                }
                else
                {
                    $bedroom_match_percent=0;
                }
            }
            else
            {
                if($this->between($property->bedrooms, $requirement->min_bedrooms, $requirement->max_bedrooms))  
                {
                    $bedroom_match_percent =100;
                }
                else
                {
                    $bedroom_match_percent =0;   
                }
            }

            //4. bathrooms
            $bathroom_match_percent=0;
            //only max bathrooms pecified for requireemnt
            if(is_null($requirement->min_bathrooms))
            {
                $min_valid = $requirement->max_bathrooms -5;
                $min_full = $requirement->max_bathrooms -2;

                if($this->between($property->bathrooms, $min_valid, $requirement->max_bathrooms))  
                {
                    if($this->between($property->bathrooms, $min_full, $requirement->max_bathrooms))
                    {
                        $bathroom_match_percent=100;
                    }
                    else///between min_valid and min_full
                    {
                        //calculate match percentage
                        $bathroom_match_percent= 40+
                            (($property->bathrooms - $min_valid)/($min_full - $min_valid)) * 60;
                        
                    }
                }
                else
                {
                    $bathroom_match_percent=0;
                }
            }
            //only min bathrooms is specified for requireemnt
            else if(is_null($requirement->max_bathrooms))
            {
                $max_valid = $requirement->min_bathrooms + 5;
                $max_full = $requirement->min_bathrooms +2;

                if($this->between($property->bathrooms, $requirement->min_bathrooms, $max_valid))  
                {
                    if($this->between($property->bathrooms, $requirement->min_bathrooms, $max_full))
                    {
                        $bathroom_match_percent=100;
                    }
                    else//between max_full and max valid
                    {
                        //calculate match percentage
                         $bathroom_match_percent= 40+
                            (($max_valid - $property->bathrooms)/($max_valid - $max_full)) * 60;
                        
                    }
                }
                else
                {
                    $bathroom_match_percent=0;
                }
            }

            else
            {
                if($this->between($property->bathrooms, $requirement->min_bathrooms, $requirement->max_bathrooms))  
                {
                    $bathroom_match_percent =100;
                }
                else
                {
                    $bathroom_match_percent =0;   
                }
            }


            //Weighted sum of match percents
            $match_percent = $distance_match_percent*30/100 + $price_match_percent*30/100 + $bedroom_match_percent*20/100 + $bathroom_match_percent*20/100;

            //if($match_percent>=40)
            //{
             $match = new PropertyRequirementMatch();
                            $match->property_id = $property->id;
                            $match->requirement_id = $requirement->id;
                            $match->distance = $distance;
                            $match->distance_match_percent = $distance_match_percent;
                            $match->price_match_percent = $price_match_percent;
                            $match->bedroom_match_percent = $bedroom_match_percent;
                            $match->bathroom_match_percent = $bathroom_match_percent;
                            $match->match_percent=$match_percent;
                            $match->save();
            //}

            //check if property/requirement combo is a valid match
            /*if($distance<=10)  
            {
                
                if(($property->price>=$requirement->min_budget ) && ($property->price<=$requirement->max_budget))  
                {
                    if(($property->bedrooms>=$requirement->min_bedrooms ) && ($property->bedrooms<=$requirement->max_bedrooms))  
                    {
                        if(($property->bathrooms>=$requirement->min_bathrooms ) && ($property->bathrooms<=$requirement->max_bathrooms))  
                        {
                            echo "valid match..Worthy of database entry";
                            //calculate match percentage contribution of earch of 4 parameters 
                            //add it up and make a match entry   
                            
                            $match = new PropertyRequirementMatch();
                            $match->property_id = $property->id;
                            $match->requirement_id = $requirement->id;
                            $match->distance = $distance;
                            $match->match_percent=100.00;
                            $match->save();

                        }           
                    }           
                }
            } 
            */ 
            


            
        }
        //add entries for match percentage with each requiremnt entry
        //get all requirement entries
        //calculate percentage match with each req entry
        //insert match entry into db
        
        $prmatch_orm = new PropertyRequirementMatch();
        
        /*
        $prmatches_all_querybuilder = DB::table('property_requirement_matches')
            ->join('requirements', 'requirements.id', '=', 'property_requirement_matches.requirement_id')
            ->select('requirements.*', 'prm.match_percent)
            ->where('property_id', '=', $property->id)
            ->orderBy('prm_match_percent','desc')
            ->get();

        echo "<pre>";

        print_r($prmatches_all_querybuilder);
        
        */

        echo "requirement matches for your property";
        $prmatches_all_raw = DB::select('select r.*, prm.match_percent from property_requirement_matches prm inner join requirements r on r.id = prm.requirement_id
            where prm.property_id = ?
            order by prm.match_percent desc', [$property->id]) ;

        //echo "<pre>";print_r($prmatches_all_raw);

        foreach($prmatches_all_raw as $key => $prmatch)
        {
            echo "<pre>";
            echo "Match No.".($key+1);
            echo "<pre>"; print_r($prmatch);
        }
       // exit;


      //return redirect('/properties')->with('success', 'property has been added');
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function between($num, $floor, $ceiling)
    {
        if(($num>=$floor ) && ($num<=$ceiling))  
            {
                return true;
            }
        else 
            {
                return false;
            }
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) 
        {
            return 0;
        }
        else 
        {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            
            $unit = strtoupper($unit);

            if ($unit == "K") 
            {
                return ($miles * 1.609344);
            } 
            else if ($unit == "N") 
            {
                return ($miles * 0.8684);
            } 
            else 
            {
                return $miles;
            }
        }
    }
}
