<template>
    <div class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ title }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="error.message" class="alert alert-danger">
                        {{ error.message }}
                    </div>
                    {{ body }}
                    <slot name="body"></slot>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ $t('cancel') }}</button>
                    <button v-if="actionLabel" @click="$emit('action', context)" :class="`btn btn-${actionType}`" type="button">
                        {{ actionLabel }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            title: {
                type: String,
            },
            content: {
                type: String,
                default: '',
            },
            actionLabel: {
                type: String,
            },
            actionType: {
                type: String,
                default: 'primary',
            },
        },
        data() {
            return {
                body: this.content,
                context: {},
                error: {},
            }
        },
        created() {
            let vm = this
            vm.$on('open', (content, context) => {
                vm.error = {}
                vm.body = content
                vm.context = context ? context : {}
                $(vm.$el).modal('show')
            })
            vm.$on('close', () => {
                $(vm.$el).modal('hide')
            })
            vm.$on('error', (error) => {
                vm.error = error
            })
        },
    }

</script>
