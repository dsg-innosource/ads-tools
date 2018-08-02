<template>
    <div class="flex flex-grow">
        <div class="mr-2">
            <div class="flex flex-col bg-white rounded shadow min-h-full max-h-full">
                <div class="flex p-4 border-b text-grey-dark">{{resource.name}} Tables</div>
                <div class="flex flex-col py-4 overflow-y-auto text-xs">
                    <div
                        v-for="(table, idx) in tables"
                        :key="idx"
                        :class="{'bg-orange-lightest' : table == selected_table}"
                        @click="selectTable(table)"
                        class="cursor-pointer no-underline text-orange hover:text-orange-dark hover:bg-orange-lightest px-4 py-1 font-mono"
                    >
                        <span v-if="table.schema">{{table.schema}}.</span>{{table.name}} ({{table.rowCount}})
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 ml-2 overflow-y-auto pr-1" ref="main">
            <div v-if="preview" class="mb-8" :style="'max-width: ' + previewWidth + 'px;'">
                <div class="flex flex-col bg-white rounded shadow">
                    <div class="flex p-4 border-b text-grey-dark justify-between">
                        <div class="flex-1"><span class="font-mono text-orange">{{selected_table.name}}</span> Random Data</div>
                        <div @click="preview = null" class="text-xs uppercase bg-grey-light rounded px-2 py-1 cursor-pointer">Close</div>
                    </div>
                    <div class="flex flex-col p-4">
                        <div class="overflow-auto">
                            <table class="text-xs">
                                <tr class="uppercase text-grey-dark font-normal">
                                    <th v-for="(row, idx) in preview[0]" :key="idx" class="border border-b-2 p-2" style="min-width: 100px;">{{idx}}</th>
                                </tr>
                                <tr v-for="(row, idx) in preview" :key="idx" class="text-grey group">
                                    <td v-for="(entry, idx2) in row" :key="idx2" class="p-2 border text-center group-hover:text-orange-darker group-hover:bg-orange-lighter">{{entry}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="selected_table">
                <div class="flex flex-col bg-white rounded shadow">
                    <div class="flex p-4 border-b text-grey-dark">
                        <div class="flex-1"><span class="font-mono text-orange">{{selected_table.name}}</span> Columns</div>
                        <div @click="createTierOneMigration" class="text-xs uppercase bg-grey-light rounded px-2 py-1 cursor-pointer mr-2">create tier1 migration</div>
                        <div @click="previewSelectedTable" class="text-xs uppercase bg-grey-light rounded px-2 py-1 cursor-pointer">preview</div>
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
            preview: null,
            previewWidth: 0
        }
    },
    mounted() {
        this.selected_table = this.tables[0];
    },
    computed: {
        tables() {
            return this.resource.tables;
        },
        mainWidth() {
            return this.$refs.main.offsetWidth;
        }
    },
    methods: {
        selectTable(table) {
            this.selected_table = table;
            this.preview = null;
        },
        previewSelectedTable() {
            var vThis = this;
            axios.post(top.location.href + '/preview', this.selected_table)
                .then(response => {
                    vThis.preview = response.data;
                    vThis.previewWidth = this.mainWidth;
                })
        },
        createTierOneMigration() {
            var vThis = this;
            axios.post(top.location.href + '/migrations/' + vThis.selected_table.name, {
                type : 't1',
                columns: vThis.selected_table.columns
            })
                .then(response => {
                    console.log(response);
                })
        }
    }
}
</script>
