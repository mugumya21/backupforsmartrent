@if(!(empty($profilepic)))
  <img class="img-fluid rounded featimg"  src="{{ asset("uploads/documents/{$profilepic->temp_key}") }}" alt="Card image cap">
  @else
  <img class="img-fluid rounded featimg"  src="{{ asset("assets/img/icons/propertyicon.png") }}" alt="Card image cap">
  @endif