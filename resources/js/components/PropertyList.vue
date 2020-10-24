<template>
    <div>
        <table v-if="properties.length" class="table table-condensed table-hover">
            <thead>
                <tr>
                    <td class="border-top-0 font-weight-bold">
                        <a href="javascript:;" @click="orderBy('id')">
                            #
                        </a>
                    </td>
                    <td class="border-top-0 font-weight-bold">
                        <a href="javascript:;" @click="orderBy('email')">
                            Nome
                        </a>
                    </td>
                    <td class="border-top-0 font-weight-bold">
                        <a href="javascript:;" @click="orderBy('street')">
                            Endereço
                        </a>
                    </td>
                    <td class="border-top-0 font-weight-bold">
                        <a href="javascript:;">
                            Status
                        </a>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="property in properties">
                    <td>
                        <a href="javascript:;" @click="getProperty(property)">{{ property.id }}</a>
                    </td>
                    <td>{{ property.email }}</td>
                    <td>{{ property.address }}</td>
                    <td>
                        <a href="javascript:;" @click="contract(property)" :class="`badge badge-${property.contract ? 'success' : 'danger'} p-2`">
                            {{ property.contract ? 'CONTRATADO' : 'NÃO CONTRATADO' }}
                        </a>
                    </td>
                    <td>
                        <a href="javascript:;" @click="remove(property)" class="close btn btn-sm btn-secondary text-white">
                            <span>&times;</span>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

        <div v-else>
            Nenhuma propriedade cadastrada.
        </div>

        <modal ref="removeConfirm" @action="removeProperty"
            title="Deseja realmente remover essa propriedade?"
            action-label="Remover"
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

            getProperty(property) {
                let vm = this
                vm.$root.$refs.propertyForm.$emit('open', property)
            },

            contract(property) {
                let vm = this
                vm.$refs.contractForm.$emit('open', property)
            },

            remove(property) {
                let vm = this
                vm.$refs.removeConfirm.$emit('open', property.address, property)
            },

            removeProperty(property) {
                let vm = this
                vm.$store.dispatch('removeProperty', property).then(response => {
                    vm.$refs.removeConfirm.$emit('close')
                }).catch(error => {
                    vm.$refs.removeConfirm.$emit('error', error)
                })
            },

            getLabel(column) {
                switch (column) {
                    case 'email': return 'E-mail'
                    case 'address': return 'Endereço'
                    case 'status': return 'Status'
                    default:
                        return ''
                }
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
