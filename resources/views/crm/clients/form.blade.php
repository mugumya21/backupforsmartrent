

@if( $client->id > 0 )
{{ html()->form('PUT')->route('crm.clients.update',$client)->class('row g-3 needs-validation')->novalidate()->open() }}
 
 @else
 {{ html()->form('POST')->route('crm.clients.store')->class('row g-3 needs-validation')->id('')->novalidate()->open() }}
 @endif

 @if( $client->id > 0 )

 {{ html()->hidden('clienttype')->value($client->clientType->code)->required()->class('form-control form-control-sm') }}

 @else 
  <div class="col-md-6">
    <label class="form-label asterik" for="marital_status_id">Client Type</label>
    {{ html()->select('clienttype')->options($clientypes->pluck('name','code'))->required()->placeholder('Select Client Type to pupulate forms')->class('form-select form-select-sm js-choice client_type_id')->id('client_type_id') }}
  </div>

@endif


        @if( $client->id > 0 )

        @if($client->clientType->code == 'IND')
        
          @include('crm.clients.editindividualClientForm')
        
        @else
        
          @include('crm.clients.editcompanyClientForm')
        
        @endif

@else 
<div id="clientformloader"></div>
@endif



    {{ html()->form()->close() }}