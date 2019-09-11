
<style>
  .outer {
    margin-top: 40px;
  }
</style>
<div class="outer">
   Add Property
  
  <div class="">
  
      <form method="post" action="{{ route('property.store') }}">
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
              <label for="price">price:</label>
              <input type="number" class="form-control" name="price" step="any"/>
          </div>
          <div class="form-group">
              <label for="bedrooms">bedrooms:</label>
              <input type="number" class="form-control" name="bedrooms"/>
          </div>
          <div class="form-group">
              <label for="bathrooms">bathrooms:</label>
              <input type="number" class="form-control" name="bathrooms"/>
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div>
