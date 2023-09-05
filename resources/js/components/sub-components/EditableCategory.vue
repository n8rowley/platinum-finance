<script>
export default {
    name: "editable-category",
    props: {
        value: {
            name: String,
            enabled: Boolean,
        },
        active: Boolean,
    },
    data(){return{
        editing: this.value.name == null,
    }},
    computed:{
        colorLogic() {
            return {
                'border-primary' : this.value.enabled,
                'text-primary': this.value.enabled && !this.active,
                'border-dark': !this.value.enabled,
                'text-dark': !this.value.enabled && !this.active,
                'bg-primary': this.value.enabled && this.active,
                'bg-dark': !this.value.enabled && this.active,
                'text-white': this.active,
            }
        }
    }

}
</script>

<template>
    <div class="d-flex align-items-center gap-x-2">
        <div class="d-flex justify-content-between align-items-center rounded-pill border border-primary flex-grow-1 px-3 py-1 cursor-pointer active-bg-tint" :class="colorLogic" @click="$emit('clicked')">
            <b-form-input v-if="editing" v-model="value.name" size="sm"></b-form-input>
            <div v-else class="px-2 py-1" style="word-break: break-all">{{ value.name }}</div>
            <b-icon v-if="editing" icon="cloud-upload" class="ml-1" @click.stop="editing = false"></b-icon>
            <b-icon v-else icon="pencil-square" @click.stop="editing = true"></b-icon>
        </div>
        <b-form-checkbox v-model="value.enabled">Enabled</b-form-checkbox>
    </div>
</template> 
