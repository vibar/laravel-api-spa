<template>
    <div class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form @submit.prevent="submit" ref="form" class="needs-validation" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ form.id ? `${$tc('contract.label')} #${form.id}` : $t('contract.add') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-if="error.message" class="alert alert-danger">
                            {{ error.message }}
                        </div>
                        <div class="form-group">
                            <label>{{ $tc('property.label') }} <span class="text-danger">*</span></label>
                            <select v-model="form.property_id" required :class="`form-control ${errorClass('property_id')}`">
                                <option v-for="property in properties" :value="property.id">
                                    {{ property.address }}
                                </option>
                            </select>
                            <div v-if="hasError('property_id')" class="invalid-feedback">
                                {{ getError('property_id') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ $tc('contract.type') }} <span class="text-danger">*</span></label>
                            <select v-model="form.type_id" required :class="`form-control ${errorClass('type_id')}`">
                                <option v-for="type in types" :value="type.id">{{ type.name }}</option>
                            </select>
                            <div v-if="hasError('type_id')" class="invalid-feedback">
                                {{ getError('type_id') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ $tc('contract.document') }} <span class="text-danger">*</span></label>
                            <input v-model="form.document" v-mask="documentMask" :pattern="documentRegex" required type="text" :class="`form-control ${errorClass('document')}`">
                            <div v-if="hasError('document')" class="invalid-feedback">
                                {{ getError('document') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ $t('contract.email') }} <span class="text-danger">*</span></label>
                            <input v-model="form.email" type="email" required :class="`form-control ${errorClass('email')}`">
                            <div v-if="hasError('email')" class="invalid-feedback">
                                {{ getError('email') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ $t('contract.name') }} <span class="text-danger">*</span></label>
                            <input v-model="form.name" required type="text" :class="`form-control ${errorClass('name')}`">
                            <div v-if="hasError('name')" class="invalid-feedback">
                                {{ getError('name') }}
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
    import {VueTheMask} from 'vue-the-mask'
    import Form from './mixins/Form'

    export default {

        mixins: [Form],

        directives: {VueTheMask},

        created() {
            this.$store.dispatch('fetchContractTypes')
        },

        computed: {
            properties() {
                let vm = this
                let properties = vm.$store.getters.propertiesWithoutContract
                if (vm.form.id) {
                    properties = vm.$store.getters.allProperties.filter(property => {
                        return property.contract && property.contract.id === vm.form.id
                    })
                }
                return properties.map(property => ({
                    ...property,
                    address: [
                        property.street,
                        property.number,
                        property.complement,
                        property.district
                    ].filter(value => {
                        return !!value
                    }).join(', ').toUpperCase()
                })).sort(function (a, b) {
                    return a.address < b.address ? -1 : 1
                })
            },
            types() {
                return this.$store.getters.allContractTypes
            },
            documentRegex() {
                if (!this.form.type_id) {
                    return ''
                }
                return this.types.find(type => type.id === this.form.type_id).document_format
            },
            documentMask() {
                if (!this.documentRegex) {
                    return ''
                }
                return new RegExp(this.documentRegex).source
                    .replace(/^\^|\$$/g, '')
                    .replace(/\\d/g, '#')
                    .replace(/\(([^)]*)\)|\[([^^])\]|\\([\\/.(){}[\]])/g, '$1$2$3')
                    .replace(/([\w#.-])\{(\d+)\}/gi, function (_, c, n) {
                        return Array(+n + 1).join(c)
                    })
            },
        },

        methods: {

            fill(property) {
                if (!property) {
                    return {}
                }
                let contract = property.contract
                if (!contract) {
                    return {
                        property_id: property.id,
                    }
                }
                contract.property_id = property.id
                contract.type_id = contract.type.id
                return contract
            },

            submit() {
                let vm = this

                vm.$refs.form.classList.add('was-validated')

                if (vm.$refs.form.checkValidity() === false) {
                    return
                }

                vm.setError()

                vm.$store.dispatch('addContract', vm.form).then(response => {
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
