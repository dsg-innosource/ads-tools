<template>
    <div class="flex flex-col bg-white p-4 rounded shadow">
        <div class="flex text-xs uppercase text-grey-dark border-b py-2">
            <div class="w-1/5 pl-2">Database</div>
            <div class="w-1/5">Name</div>
            <div class="w-1/5">Driver</div>
            <div class="w-1/5">Host</div>
            <div class="w-1/5">Port</div>
            <div class="w-1/5 pr-2">Username</div>
        </div>
        <div class="flex text-sm text-grey py-2 hover:bg-grey-lighter hover:text-grey-darker" v-for="(connection, idx) in connections" :key="idx">
            <div class="w-1/5 pl-2">
                <a :href="baseUrl + '/connections/' + connection.name" class="no-underline text-orange hover:text-orange-dark">{{connection.database}}</a>
            </div>
            <div class="w-1/5">{{connection.name}}</div>
            <div class="w-1/5">{{connection.driver}}</div>
            <div class="w-1/5">{{connection.host}}</div>
            <div class="w-1/5">{{connection.port}}</div>
            <div class="w-1/5 pr-2">{{connection.username}}</div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        connections: Object,
        baseUrl: String
    }
}
</script>
