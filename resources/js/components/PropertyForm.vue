<template>
    <div class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form @submit.prevent="submit('addProperty')" ref="form" class="needs-validation" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ form.id ? `${$tc('property.label')} #${form.id}` : $t('property.add') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <error-message :error="error"></error-message>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>{{ $t('property.email') }} <span class="text-danger">*</span></label>
                                    <input v-model="form.email" type="email" required :class="`form-control ${errorClass('email')}`">
                                    <div v-if="hasError('email')" class="invalid-feedback">
                                        {{ getError('email') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>{{ $t('property.street') }} <span class="text-danger">*</span></label>
                                    <input type="text" v-model="form.street" required :class="`form-control ${errorClass('street')}`">
                                    <div v-if="hasError('street')" class="invalid-feedback">
                                        {{ getError('street') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>{{ $t('property.number') }}</label>
                                    <input type="text" v-model="form.number" :class="`form-control ${errorClass('number')}`">
                                    <div v-if="hasError('number')" class="invalid-feedback">
                                        {{ getError('number') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>{{ $t('property.complement') }}</label>
                                    <input type="text" v-model="form.complement" :class="`form-control ${errorClass('complement')}`">
                                    <div v-if="hasError('complement')" class="invalid-feedback">
                                        {{ getError('complement') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>{{ $t('property.district') }} <span class="text-danger">*</span></label>
                                    <input v-model="form.district" required type="text" :class="`form-control ${errorClass('district')}`">
                                    <div v-if="hasError('district')" class="invalid-feedback">
                                        {{ getError('district') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>{{ $tc('state.label') }} <span class="text-danger">*</span></label>
                                    <select v-model="form.state_id" required :class="`form-control ${errorClass('state_id')}`">
                                        <option v-for="state in states" :value="state.id">{{ state.name }}</option>
                                    </select>
                                    <div v-if="hasError('state_id')" class="invalid-feedback">
                                        {{ getError('state_id') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>{{ $tc('city.label') }} <span class="text-danger">*</span></label>
                                    <select v-model="form.city_id" required :class="`form-control ${errorClass('city_id')}`">
                                        <option v-if="!form.state_id" value="">{{ $t('state.select') }}</option>
                                        <option v-for="city in cities" :value="city.id">{{ city.name }}</option>
                                    </select>
                                    <div v-if="hasError('city_id')" class="invalid-feedback">
                                        {{ getError('city_id') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">{{ $t('cancel') }}</button>
                        <button v-if="!form.id" type="submit" class="btn btn-primary">{{ $t('save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from './mixins/Form'

    export default {

        mixins: [Form],

        computed: {
            states() {
                return this.$store.getters.allStates
            },
            cities() {
                return this.$store.getters.allCities
            },
        },

        watch: {
            'form.state_id'(value) {
                if (value) {
                    let state = this.states.find(state => state.id === value)
                    this.$store.dispatch('fetchCities', state)
                }
            },
        },

        created() {
            this.$store.dispatch('fetchStates')
        },

        methods: {

            fill(property) {
                if (!property) {
                    return {}
                }
                property.state_id = property.city.state.id
                property.city_id = property.city.id
                return property
            },
        },
    }
</script>
