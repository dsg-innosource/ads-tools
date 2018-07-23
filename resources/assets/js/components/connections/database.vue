<template>
    <div class="flex flex-grow">
        <div class="mr-2">
            <div class="flex flex-col bg-white rounded shadow min-h-full max-h-full">
                <div class="flex p-4 border-b text-grey-dark">{{resource.name}} Tables</div>
                <div class="flex flex-col p-4 overflow-y-auto text-xs">
                    <div
                        v-for="(table, idx) in tables"
                        :key="idx"
                        :class="{'bg-orange-lightest' : table == selected_table}"
                        @click="selectTable(table)"
                        class="cursor-pointer rounded no-underline text-orange hover:text-orange-dark p-1">{{table.name}} ({{table.rowCount}})</div>
                </div>
            </div>
        </div>
        <div class="flex-1 ml-2 overflow-y-auto">
            <div v-if="selected_table">
                <div class="flex flex-col bg-white rounded shadow">
                    <div class="flex p-4 border-b text-grey-dark">
                        <div class="flex-1">{{selected_table.name}} Columns</div>
                        <div @click="previewSelectedTable">preview</div>
                    </div>
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
            <div v-if="preview" class="mt-8">
                <div class="flex flex-col bg-white rounded shadow">
                    <div class="flex p-4 border-b text-grey-dark">
                        <div class="flex-1">{{selected_table.name}} Data</div>
                    </div>
                    <div class="flex flex-col p-4">
                        <div>
                            <div class="flex justify-between text-xs uppercase text-grey-dark border-b py-2">
                                <div class="pl-2" v-for="(row, idx) in preview[0]" :key="idx">{{idx}}</div>
                            </div>
                            <div class="flex justify-between text-sm text-grey py-2 hover:bg-orange-lighter hover:text-orange-darker" v-for="(row, idx) in preview" :key="idx">
                                <div v-for="(entry, idx2) in row" :key="idx2" class="pl-2">{{entry}}</div>
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
            selected_table: null,
            preview: null
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
        },
        previewSelectedTable() {
            var vThis = this;
            axios.post(top.location.href + '/preview', this.selected_table)
                .then(response => {
                    vThis.preview = response.data;
                })
        }
    }
}
</script>
