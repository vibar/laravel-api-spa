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

            async submit(action) {
                this.$refs.form.classList.add('was-validated')

                if (this.$refs.form.checkValidity() === false) {
                    return
                }

                this.setError()

                try {
                    await this.$store.dispatch(action, this.form)
                    this.$refs.form.classList.remove('was-validated')
                    this.$emit('close')
                } catch (error) {
                    this.$refs.form.classList.remove('was-validated')
                    this.setError(error)
                }
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
                if (!error) {
                    this.error = {
                        errors: [],
                        message: '',
                    }
                    return
                }

                if (!error.response) {
                    this.error = {
                        errors: [],
                        message: error.message,
                    }
                    return
                }

                if (error.response.status === 422) {
                    let errors = error.response.data.errors
                    if (errors.general && errors.general.length) {
                        this.error = {
                            errors: [],
                            message: errors.general[0],
                        }
                        return
                    }
                    this.error = {
                        errors: errors,
                        message: '',
                    }
                    return
                }

                this.error = {
                    errors: [],
                    message: error.response.data.message,
                }
            },
        },
    }
</script>
