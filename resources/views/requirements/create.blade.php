
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="uper">
    Add Requirement
  
  <div class="">
    
      <form method="post" action="{{ route('requirement.store') }}">
          <div class="form-group">
              @csrf
              <label for="latitude">latitude:</label>
              <input type="number" class="form-control" name="latitude" step="any"/>
          </div>
          <div class="form-group">
              <label for="longitude">longitude :</label>
              <input type="number" class="form-control" name="longitude" step="any"/>
          </div>
          <div class="form-group">
              <label for="min_budget">min_budget:</label>
              <input type="number" class="form-control" name="min_budget" step="any"/>
          </div>
          <div class="form-group">
              <label for="max_budget">max_budget:</label>
              <input type="number" class="form-control" name="max_budget" step="any"/>
          </div>
          <div class="form-group">
              <label for="min_bedroom">min_bedroom:</label>
              <input type="number" class="form-control" name="min_bedroom"/>
          </div>
          <div class="form-group">
              <label for="max_bedroom">max_bedroom:</label>
              <input type="number" class="form-control" name="max_bedroom"/>
          </div>
          <div class="form-group">
              <label for="min_bathroom">min_bathroom:</label>
              <input type="number" class="form-control" name="min_bathroom"/>
          </div>
          <div class="form-group">
              <label for="max_bathroom">max_bathroom:</label>
              <input type="number" class="form-control" name="max_bathroom"/>
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div>
