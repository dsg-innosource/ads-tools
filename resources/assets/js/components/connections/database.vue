<template>
    <div class="flex w-full">
        <div class="w-1/4 mr-2">
            <div class="flex flex-col bg-white rounded shadow">
                <div class="flex p-4 border-b text-grey-dark">{{resource.name}} Tables</div>
                <div class="flex flex-col p-4">
                    <div
                        v-for="(table, idx) in tables"
                        :key="idx"
                        :class="{'bg-orange-lightest' : table == selected_table}"
                        @click="selectTable(table)"
                        class="cursor-pointer rounded no-underline text-orange hover:text-orange-dark p-1">{{table.name}} ({{table.rowCount}})</div>
                </div>
            </div>
        </div>
        <div class="w-3/4 ml-2">
            <div v-if="selected_table">
                <div class="flex flex-col bg-white rounded shadow">
                    <div class="flex p-4 border-b text-grey-dark">{{selected_table.name}} Columns</div>
                    <div class="flex flex-col p-4">
                        <div>
                            <div class="flex text-xs uppercase text-grey-dark border-b py-2">
                                <div class="flex-1 pl-2">Name</div>
                                <div class="w-64">Type</div>
                                <div class="w-64">Default</div>
                                <div class="w-32 pr-2">Nullable</div>
                            </div>
                            <div class="flex text-sm text-grey py-2 hover:bg-orange-lighter hover:text-orange-darker" v-for="(col, idx) in selected_table.columns" :key="idx">
                                <div class="flex-1 pl-2">{{col.name}}</div>
                                <div class="w-64">{{col.type}}</div>
                                <div class="w-64">{{col.default}}</div>
                                <div class="w-32 pr-2">{{col.nullable}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        resource: Object
    },
    data() {
        return {
            selected_table: null
        }
    },
    mounted() {
        this.selected_table = this.tables[0];
    },
    computed: {
        tables() {
            return this.resource.tables;
        }
    },
    methods: {
        selectTable(table) {
            this.selected_table = table;
        }
    }
}
</script>
