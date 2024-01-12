<template>
    <div>
        <b-alert v-if="mode == 'success'" v-model="showFor" variant="success" fade class="mb-0">
            {{ displayInfo.message }}
            <b-progress :max="dismissSecondsSuccess - 1" :value="showFor - 1" variant="success" height="2px"></b-progress>
        </b-alert>
        <b-alert v-if="mode == 'error'" show variant="danger" class="mb-0" fade dismissible @dismissed="mode = null">
            Error: {{ displayInfo.message }}
            <ul v-if="displayInfo.errors" class="mb-0" style="list-style-type: disc; list-style-position: inside;">
                <li v-for="(fieldErrors, field, index) in displayInfo.errors" :key="index">
                    {{ field.charAt(0).toUpperCase() + field.replace('_', ' ').slice(1) }}: {{ fieldErrors.join(' ') }}
                </li>
            </ul>
        </b-alert>
        <b-alert v-if="mode == 'info'" v-model="showFor" variant="info" dismissible @dismissed="mode = null" class="mb-0">
            {{ displayInfo.message }}
        </b-alert>
    </div>
</template>

<script>
export default {
    name: "fetch-feedback",
    data(){return{
        dismissSecondsSuccess: 5,
        dimsissSecondsInfo: 60,
        showFor: 0,
        displayInfo: {},
        mode: null,
    }},
    methods:{ // called externally
        success(data){
            this.mode = 'success';
            this.displayInfo = data;
            this.showFor = this.dismissSecondsSuccess;
        },
        error(data){
            this.mode = 'error';
            this.displayInfo = data;
        },
        info(data){
            this.mode = 'info';
            this.displayInfo = data;
            this.showFor = this.dimsissSecondsInfo;
        }
    }
}
</script>
