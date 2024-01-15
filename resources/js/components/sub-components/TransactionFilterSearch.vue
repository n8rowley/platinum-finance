<template>
    <span>
        <b-icon v-if="filter !== null" :id="'filter-search-'+parentKey" icon="filter-square-fill" variant="secondary"/>
        <b-icon v-else :id="'filter-search-'+parentKey" icon="filter-square" variant="secondary"/>
        <b-popover :target="'filter-search-'+parentKey" triggers="focus" placement="bottom">
            <b-input-group size="sm">
                <template #prepend>
                    <b-input-group-text>
                        <b-icon icon="search"/>
                    </b-input-group-text>
                </template>
                <b-form-input :id="'search-subject'+parentKey" v-model="filter"></b-form-input>
                <template #append>
                    <b-button variant="primary"><b-icon icon="x" @click="filter = null"/></b-button>
                </template>
            </b-input-group>
        </b-popover>
    </span>
</template>

<script>
export default {
    name: "TransactionFilterSearch",
    props:{
        value: String,
    },
    data() {
        return {
            filter: this.value,
            parentKey: this.$vnode.key,
        }
    },
    watch: {
        filter(newVal){
            this.$emit('input',newVal);
        }
    }
}
</script>
