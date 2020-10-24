@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header">
                <h5 class="align-middle float-left mb-0" style="line-height: 2.1;">
                    @{{ $tc('property.label', 2) }}
                </h5>
                <div class="btn-group float-right" role="group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        @{{ $t('add') }}
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" @click="$refs.propertyForm.$emit('open')" href="javascript:;">
                            @{{ $tc('property.label') }}
                        </a>
                        <a v-if="addContractEnabled" class="dropdown-item" @click="$refs.contractForm.$emit('open')" href="javascript:;">
                            @{{ $tc('contract.label') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <property-list></property-list>
                <property-form ref="propertyForm"></property-form>
                <contract-form ref="contractForm"></contract-form>
            </div>
        </div>
    </div>
</div>
@endsection
