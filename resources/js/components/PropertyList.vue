<template>
    <div>
        <error-message :error="error"></error-message>
        <table v-if="properties.length" class="table table-condensed table-hover">
            <thead>
                <tr>
                    <td v-for="column in columns" class="border-top-0 font-weight-bold">
                        <a href="javascript:;" @click="orderBy(column)">
                            {{ column.label }}
                        </a>
                        <span v-if="order.column === column.id">
                            {{ order.direction === 'asc' ? '&uarr;' : '&darr;' }}
                        </span>
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

    import Error from './mixins/Error'

    export default {

        mixins: [Error],

        data() {
            return {
                columns: [
                    {
                        id: 'id',
                        label: '#',
                        sort: true,
                    }, {
                        id: 'email',
                        label: this.$t('property.email'),
                        sort: true,
                    }, {
                        id: 'street',
                        label: this.$t('property.address'),
                        sort: true,
                    }, {
                        id: 'status',
                        label: this.$t('property.status'),
                        sort: false,
                    }, {
                        id: '',
                        label: '',
                        sort: false,
                    },
                ],
                order: {
                    column: 'email',
                    direction: 'asc',
                },
            }
        },

        async created() {
            try {
                await this.$store.dispatch('fetchProperties')
            } catch (error) {
                this.setError(error)
            }
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
                this.$root.$refs.propertyForm.$emit('open', property)
            },

            contractView(property) {
                this.$refs.contractForm.$emit('open', property)
            },

            removeConfirm(property) {
                this.$refs.removeConfirm.$emit('open', property.address, property)
            },

            async removeProperty(property) {
                try {
                    await this.$store.dispatch('removeProperty', property)
                    this.$refs.removeConfirm.$emit('close')
                } catch (error) {
                    this.$refs.removeConfirm.$emit('error', error)
                }
            },

            orderBy(column) {
                if (!column.sort) {
                    return
                }
                let direction = this.order.column === column.id && this.order.direction === 'asc'
                this.order.direction = direction ? 'desc' : 'asc'
                this.order.column = column.id
                this.$store.dispatch('fetchProperties', {'order': this.order})
            },
        },
    }
</script>
