<script>

export default {

    data() {
        return {
            error: {},
        }
    },

    methods: {

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
