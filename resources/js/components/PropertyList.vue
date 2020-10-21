<template>
    <div>
        <table v-if="properties.length" class="table table-condensed table-hover">
            <thead>
                <tr>
                    <td v-for="column in columns" class="border-top-0 font-weight-bold">
                        <a @click="orderBy(column)" href="">
                            {{ getLabel(column) }}
                        </a>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="property in properties">
                    <td>{{ property.email }}</td>
                    <td>{{ property.address }}</td>
                    <td>
                        <a href="#" @click="contract(property)" :class="`badge badge-${property.contract ? 'success' : 'danger'} p-2`">
                            {{ property.contract ? 'CONTRATADO' : 'NÃO CONTRATADO' }}
                        </a>
                    </td>
                    <td>
                        <a href="#" @click="remove(property)" class="close btn btn-sm btn-secondary text-white">
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

        props: {
            columns: {
                type: Array,
                default: () => {
                    return ['email', 'address', 'status']
                },
            },
        },

        computed: {
            properties() {
                return this.$store.getters.allProperties
            },
        },

        methods: {

            contract(property) {
                let vm = this
                vm.$refs.contractForm.$emit('open', property)
            },

            remove(property) {
                let vm = this
                vm.$refs.removeConfirm.$emit('open', property.email, property)
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

            orderBy(field) {
                alert('order by ' + field)
            },
        },
    }
</script>
