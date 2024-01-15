<template>
    <span>
        <b-icon v-if="filter !== null" :id="'filter-boolean-'+parentKey" icon="filter-square-fill" variant="secondary"/>
        <b-icon v-else :id="'filter-boolean-'+parentKey" icon="filter-square" variant="secondary"/>
        <b-popover :target="'filter-boolean-'+parentKey" triggers="focus" placement="bottom">
            <b-form-radio-group
                v-model="filter"
                :options="options"
                @input="$emit('input',$event)"
                stacked
            />
        </b-popover>
    </span>
</template>

<script>
export default {
    name: "TransactionFilterBoolean",
    props:{
        value: Boolean,
        trueLabel: {type: String, default: 'True'},
        falseLabel: {type: String, default: 'False'},
    },
    data() {
        return {
            filter: this.value,
            options: [
                {text: 'Both', value: null},
                {text: this.trueLabel, value: true},
                {text: this.falseLabel, value: false},
            ],
            parentKey: this.$vnode.key,
        }
    },
}
</script>
