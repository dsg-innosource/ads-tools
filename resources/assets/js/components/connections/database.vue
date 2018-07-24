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
        <div class="flex-1 ml-2 overflow-y-auto pr-1" ref="main">
            <div v-if="selected_table">
                <div class="flex flex-col bg-white rounded shadow">
                    <div class="flex p-4 border-b text-grey-dark">
                        <div class="flex-1">{{selected_table.name}} Columns</div>
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
            <div v-if="preview" class="mt-8" :style="'max-width: ' + previewWidth + 'px;'">
                <div class="flex flex-col bg-white rounded shadow">
                    <div class="flex p-4 border-b text-grey-dark">
                        <div class="flex-1">{{selected_table.name}} Data</div>
                    </div>
                    <div class="flex flex-col p-4">
                        <div class="overflow-auto">
                            <table class="text-xs">
                                <tr class="uppercase text-grey-dark font-normal">
                                    <th v-for="(row, idx) in preview[0]" :key="idx" class="border border-b-2 p-2" style="min-width: 100px;">{{idx}}</th>
                                </tr>
                                <tr v-for="(row, idx) in preview" :key="idx" class="text-grey">
                                    <td v-for="(entry, idx2) in row" :key="idx2" class="p-2 border text-center">{{entry}}</td>
                                </tr>
                            </table>
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
        this.selected_table = this.tables[4];
        this.previewSelectedTable();
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
        }
    }
}
</script>
