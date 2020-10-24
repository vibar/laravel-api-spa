@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header">
                <h5 class="align-middle float-left mb-0" style="line-height: 2.1;">
                    <span v-text="$tc('property.label', 2)"></span>
                </h5>
                <div class="btn-group float-right" role="group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        <span v-text="$t('add')"></span>
                    </button>
                    <div class="dropdown-menu">
                        <a @click="addProperty" class="dropdown-item" href="javascript:;">
                            <span v-text="$tc('property.label')"></span>
                        </a>
                        <a v-if="addContractEnabled" @click="addContract" class="dropdown-item" href="javascript:;">
                            <span v-text="$tc('contract.label')"></span>
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
