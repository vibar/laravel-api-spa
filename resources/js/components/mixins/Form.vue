<script>
    import Error from './Error'

    export default {

        mixins: [Error],

        data() {
            return {
                form: {},
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

            errorClass(key) {
                if (!this.hasError(key)) {
                    return ''
                }
                return 'is-invalid'
            },
        },
    }
</script>
