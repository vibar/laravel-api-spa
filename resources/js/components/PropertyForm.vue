<template>
    <div class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form @submit.prevent="submit" ref="form" class="needs-validation" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title">Nova propriedade</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-if="error.message" class="alert alert-danger">
                            {{ error.message }}
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>E-mail <span class="text-danger">*</span></label>
                                    <input v-model="form.email" type="email" required :class="`form-control ${errorClass('email')}`">
                                    <div v-if="hasError('email')" class="invalid-feedback">
                                        {{ getError('email') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Estado <span class="text-danger">*</span></label>
                                    <select v-model="form.state_id" required :class="`form-control ${errorClass('state_id')}`">
                                        <option v-for="state in states" :value="state.id">{{ state.name }}</option>
                                    </select>
                                    <div v-if="hasError('state_id')" class="invalid-feedback">
                                        {{ getError('state_id') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Cidade <span class="text-danger">*</span></label>
                                    <select v-model="form.city_id" required :class="`form-control ${errorClass('city_id')}`">
                                        <option v-if="!form.state_id" value="">Selecione um estado</option>
                                        <option v-for="city in cities" :value="city.id">{{ city.name }}</option>
                                    </select>
                                    <div v-if="hasError('city_id')" class="invalid-feedback">
                                        {{ getError('city_id') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Bairro <span class="text-danger">*</span></label>
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
                                    <label>Rua <span class="text-danger">*</span></label>
                                    <input type="text" v-model="form.street" required :class="`form-control ${errorClass('street')}`">
                                    <div v-if="hasError('street')" class="invalid-feedback">
                                        {{ getError('street') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Número</label>
                                    <input type="text" v-model="form.number" :class="`form-control ${errorClass('number')}`">
                                    <div v-if="hasError('number')" class="invalid-feedback">
                                        {{ getError('number') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Complemento</label>
                                    <input type="text" v-model="form.complement" :class="`form-control ${errorClass('complement')}`">
                                    <div v-if="hasError('complement')" class="invalid-feedback">
                                        {{ getError('complement') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
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

            submit() {
                let vm = this

                vm.$refs.form.classList.add('was-validated')

                if (vm.$refs.form.checkValidity() === false) {
                    return
                }

                vm.setError()

                vm.$store.dispatch('addProperty', vm.form).then(response => {
                    vm.$refs.form.classList.remove('was-validated')
                    vm.$emit('close')
                }).catch(error => {
                    vm.$refs.form.classList.remove('was-validated')
                    vm.setError(error)
                })
            },
        },
    }
</script>
