PHP, Laravel, Mysql

Property Match App for Radius Agent


http://127.0.0.1:8000/property/create
can create a new property You will get all requirement matches on submitting. 
Matches will be should in descending order of match percent.  ONly matches with 40% or above match percent will be shown

http://127.0.0.1:8000/requirement/create
can create a new requirement You will get all requirement matches on submitting. 
Matches will be should in descending order of match percent. ONly matches with 40% or above match percent will be shown


Tables = Property, Requirement, Property_Requirement_Match

-Currently choosing to add all combination to property_requirement_match table.
-Alternate option could be to only add matches with more than 40% match percent (i.e. valid matches ) to the database. 

For each property requirement combination, we calculate it's match percentage;
this is a weighted sum of 
1. Distance Match (30%)
2. Price Match(30%)
3. Bedrooms match  (20%)
4. Bathroom match (20%)


-----
1. Distance match algorithm
    we claculate distance using the forula given here. https://www.geodatasource.com/developers/php . 
    Verified for few cases approxiately on google maps. 
    This URL is good for vexact distance verification between 2 locations: https://www.movable-type.co.uk/scripts/latlong.html
    if distance is 
    -more than 10 miles it is a 0% distance match.
    -10 miles- 40% match
    -2 miles or less it is 100% match
    -between 2 and 10 the distance match percent decreases linearly from 100% to 40% from Mile 2 to Mile 10.
    
2. Price match algorithm
-if requirement budget max and min are specified, then if property price is within the budget it is 100% match otherwise 0% match
-if only max budget is specified, 
    more than max budget is 0% match
    max budget to (max budget-10%) is a 100% match. 
    less than (max budget-25%) is a 0% match
    (max_budget-25%) is a 40% match
    (max budget-10%) to (max_budget-25%) is a linear decrease from 100% to 40%
-if only min budget is specified
    less than min budget is 0% match
    min budget to (min budget+10%) is a 100% match. 
    more than (min budget+25%) is a 0% match
    (min_budget+25%) is a 40% match
    (minbudget+10%) to min_budget+25%) is a linear decrease from 100% to 40%

3. Bedroom and Bathroom match algorithms
-if requirement  max and min are specified, then if property rooms are within the range it is 100% match otherwise 0% match
-if only max rooms are specified, 
    more than max is 0% match
    max to (max -2) is a 100% match. 
    less than (max -5) is a 0% match
    (max-5) is a 40% match
    (max -2) to (max-5) is a linear decrease from 100% to 40%
-if only min rooms are specified
    less than min is 0% match
    min to (min budget+2) is a 100% match. 
    more than (min+5) is a 0% match
    (min+5) is a 40% match
    (min+2) to (min+5) is a linear decrease from 100% to 40%

-------



