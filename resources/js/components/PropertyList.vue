<template>
    <div>
        <!-- TODO: refactoring columns repetition -->
        <table v-if="properties.length" class="table table-condensed table-hover">
            <thead>
                <tr>
                    <td class="border-top-0 font-weight-bold">
                        <a href="javascript:;" @click="orderBy('id')">
                            #
                        </a>
                        <span v-if="order.column === 'id'">
                            {{ order.direction === 'asc' ? '&uarr;' : '&darr;' }}
                        </span>
                    </td>
                    <td class="border-top-0 font-weight-bold">
                        <a href="javascript:;" @click="orderBy('email')">
                            {{ $t('property.email') }}
                        </a>
                        <span v-if="order.column === 'email'">
                            {{ order.direction === 'asc' ? '&uarr;' : '&darr;' }}
                        </span>
                    </td>
                    <td class="border-top-0 font-weight-bold">
                        <a href="javascript:;" @click="orderBy('street')">
                            {{ $t('property.address') }}
                        </a>
                        <span v-if="order.column === 'street'">
                            {{ order.direction === 'asc' ? '&uarr;' : '&darr;' }}
                        </span>
                    </td>
                    <td class="border-top-0 font-weight-bold">
                        <a href="javascript:;">
                            {{ $t('property.status') }}
                        </a>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="property in properties">
                    <td>
                        <a class="font-weight-bold" @click="propertyView(property)" href="javascript:;" >
                            {{ property.id }}
                        </a>
                    </td>
                    <td>{{ property.email }}</td>
                    <td>{{ property.address }}</td>
                    <td>
                        <a href="javascript:;" @click="contractView(property)" :class="`text-uppercase badge badge-${property.contract ? 'success' : 'danger'} p-2`">
                            {{ property.contract ? $t(`property.contracted`) : $t('property.not_contracted') }}
                        </a>
                    </td>
                    <td>
                        <a href="javascript:;" @click="removeConfirm(property)" class="close btn btn-sm btn-secondary text-white">
                            <span>&times;</span>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

        <div v-else>
            {{ $t('property.empty_results') }}
        </div>

        <modal ref="removeConfirm" @action="removeProperty"
            :title="$t('property.remove_confirm')"
            :action-label="$t('property.remove')"
            action-type="danger"
        />

        <contract-form ref="contractForm"></contract-form>

    </div>
</template>

<script>

    export default {

        data() {
            return {
                order: {
                    column: 'email',
                    direction: 'asc',
                },
            }
        },

        created() {
            this.$store.dispatch('fetchProperties')
        },

        computed: {
            properties() {
                return this.$store.getters.allProperties.map(property => ({
                    ...property,
                    address: [
                        property.street,
                        property.number,
                        property.city.name,
                        property.city.state.name
                    ].filter(value => {
                        return !!value
                    }).join(', ').toUpperCase()
                }))
            },
        },

        methods: {

            propertyView(property) {
                let vm = this
                vm.$root.$refs.propertyForm.$emit('open', property)
            },

            contractView(property) {
                let vm = this
                vm.$refs.contractForm.$emit('open', property)
            },

            removeConfirm(property) {
                let vm = this
                vm.$refs.removeConfirm.$emit('open', property.address, property)
            },

            removeProperty(property) {
                let vm = this
                vm.$store.dispatch('removeProperty', property)
                    .then(response => vm.$refs.removeConfirm.$emit('close'))
                    .catch(error => vm.$refs.removeConfirm.$emit('error', error))
            },

            orderBy(column) {
                let vm = this
                vm.order.column = column
                vm.order.direction = vm.order.direction === 'asc' ? 'desc' : 'asc'
                this.$store.dispatch('fetchProperties', {'order': vm.order})
            },
        },
    }
</script>
