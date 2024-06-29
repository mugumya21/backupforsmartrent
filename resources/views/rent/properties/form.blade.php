

  @if( $property->id > 0 )
 {{ html()->form('PUT')->route('rent.properties.update',$property)->class('row g-3 needs-validation')->novalidate()->open() }}

@else
{{ html()->form('POST')->route('rent.properties.store')->class('row g-3 needs-validation')->novalidate()->open() }}
@endif


  <div class="col-md-4">
  <label class="form-label asterik" for="first_name">Property name</label>
  {{ html()->text('name')->autofocus()->required()->value($property->name)->placeholder('Property name')->class('form-control form-control-sm')->id('validationCustom01') }}

</div>


<div class="col-md-4">
  <label class="form-label" for="middle_name">Location</label>
  {{ html()->text('location')->value($property->location)->placeholder('Location')->class('form-control form-control-sm') }}

</div>

<div class="col-md-4">
  <label class="form-label asterik" for="last_name">Square meters</label>
  {{ html()->text('square_meters')->value($property->square_meters)->placeholder('Square Meters')->class('form-control form-control-sm comma-separated') }}
</div>

<div class="col-md-4">
  <label class="form-label asterik" for="code">Property Category</label>
  {{ html()->select('property_category_id')->options($categories->pluck('name','id'))->value($property->property_category_id)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice') }}
</div>

<div class="col-md-4">
  <label class="form-label asterik" for="code">Property Type</label>
  {{ html()->select('property_type_id')->options($types->pluck('name','id'))->value($property->property_category_id)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice') }}
</div>

<div class="col-md-12">
  <label class="form-label" for="tin_number">Description</label>
  {{ html()->textarea('description')->value($property->description)->placeholder('Description')->class('form-control form-control-sm')->rows('5') }}
</div>

    <div class="col-12">
      <button class="btn btn-primary" type="submit">Submit</button>
    </div>

    {{ html()->form()->close() }}