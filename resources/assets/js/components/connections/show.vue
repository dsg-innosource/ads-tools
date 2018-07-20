<template>
    <div class="flex flex-1">
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
