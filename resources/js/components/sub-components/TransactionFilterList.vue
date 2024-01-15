<template>
    <span>
        <b-icon v-if="filterActive" :id="'filter-list-'+parentKey" icon="filter-square-fill" variant="secondary"/>
        <b-icon v-else :id="'filter-list-'+parentKey" icon="filter-square" variant="secondary"/>
        <b-popover :target="'filter-list-'+parentKey" triggers="focus" placement="bottom">
            <b-form-checkbox-group v-model="filter" :options="options" :text-field="textField" :value-field="valueField" @input="$emit('input',$event)"/>
        </b-popover>
    </span>
</template>

<script>
export default {
    name: "TransactionFilterList",
    props:{
        options: Array,
        value: Array,
        textField: {type: String, default: 'text'},
        valueField: {type: String, default: 'value'},
    },
    data(){return{
        filter: this.value,
        parentKey: this.$vnode.key,
    }},
    computed:{
        filterActive(){
            return !_.isEmpty(this.filter);
        }
    }
}
</script>
