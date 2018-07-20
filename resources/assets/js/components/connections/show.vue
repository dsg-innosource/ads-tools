<template>
    <div class="flex">
        <component v-bind:is="'resource-database'" :resource="resource"></component>
    </div>
</template>
<script>
export default {
    props: {
        resource: Object
    }
}
</script>
