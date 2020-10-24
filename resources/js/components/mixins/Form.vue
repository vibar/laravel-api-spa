<script>
    export default {

        data() {
            return {
                form: {},
                error: {},
            }
        },

        mounted() {
            let vm = this
            vm.$on('open', (form) => {
                vm.reset(form)
                $(vm.$el).modal('show')
            })
            vm.$on('close', () => {
                $(vm.$el).modal('hide')
            })
        },

        methods: {

            reset(form) {
                let vm = this
                vm.form = vm.fill(form)
                vm.$refs.form.classList.remove('was-validated')
                vm.$refs.form.querySelectorAll('.form-control').forEach(input => {
                    input.disabled = !!vm.form.id
                })
                vm.setError()
            },

            submit(action) {
                let vm = this

                vm.$refs.form.classList.add('was-validated')

                if (vm.$refs.form.checkValidity() === false) {
                    return
                }

                vm.setError()

                vm.$store.dispatch(action, vm.form).then(response => {
                    vm.$refs.form.classList.remove('was-validated')
                    vm.$emit('close')
                }).catch(error => {
                    vm.$refs.form.classList.remove('was-validated')
                    vm.setError(error)
                })
            },

            fill(form) {
                return form ? form : {}
            },

            hasError(key) {
                if (!this.error.errors) {
                    return false
                }
                return !!this.error.errors[key]
            },

            getError(key) {
                if (!this.error.errors) {
                    return ''
                }
                return this.error.errors[key][0]
            },

            errorClass(key) {
                if (!this.hasError(key)) {
                    return ''
                }
                return 'is-invalid'
            },

            setError(error) {
                let vm = this

                if (!error) {
                    vm.error = {
                        errors: [],
                        message: '',
                    }
                    return
                }

                if (!error.response) {
                    vm.error = {
                        errors: [],
                        message: error.message,
                    }
                    return
                }

                if (error.response.status === 422) {
                    let errors = error.response.data.errors
                    if (errors.general && errors.general.length) {
                        vm.error = {
                            errors: [],
                            message: errors.general[0],
                        }
                        return
                    }
                    vm.error = {
                        errors: errors,
                        message: '',
                    }
                    return
                }

                vm.error = {
                    errors: [],
                    message: error.response.data.message,
                }
            },
        },
    }
</script>
