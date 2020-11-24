<template>
    <div v-if="error.message" class="alert alert-danger">
        {{ error.message }}
    </div>
</template>

<script>

export default {

    props: ['error']

}

</script>
