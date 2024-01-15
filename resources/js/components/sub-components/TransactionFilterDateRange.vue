<template>
    <div style="width: 38rem">
        <b-dropdown :id="'daterange-collapse-'+parentKey" 
            text="Date Range"
            block no-caret
            menu-class="w-100"
            class="mt-1"
            size="sm"
        >
            <template #button-content>
                <b>Date Range:</b> 
                <span v-if="start == '' && end == ''">All</span>
                <span v-else-if="start != '' && end != ''">{{ (new Date(start+" MST").toLocaleDateString()) }} - {{ (new Date(end+" MST").toLocaleDateString()) }}</span>
                <span v-else-if="start == ''">Earliest - {{ (new Date(end+" MST")).toLocaleDateString() }}</span>
                <span v-else>{{ (new Date(start+" MST")).toLocaleDateString() }} - Latest</span>
            </template>
            <b-dropdown-form>
                <div class="d-flex gap-x-2 justify-content-between">
                    <b-calendar v-model="start"
                        :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                        hide-header
                        @input="$emit('update:startDate',$event)"
                    >
                        <b-button @click="start=''" variant="outline-danger" block size="sm">Clear Date</b-button>
                    </b-calendar>
                    <b-calendar v-model="end"
                        :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                        hide-header
                        @input="$emit('update:endDate',$event)"
                    >
                        <b-button @click="end=''" variant="outline-danger" block size="sm">Clear Date</b-button>
                    </b-calendar>
                </div>
            </b-dropdown-form>
        </b-dropdown>
    </div>
</template>

<script>
export default {
    name: "TransactionFilterSearch",
    props:{
        startDate: String,
        endDate: String,
    },
    data() {
        return {
            start: this.startDate,
            end: this.endDate,
            parentKey: this.$vnode.key,
        }
    },
}
</script>
