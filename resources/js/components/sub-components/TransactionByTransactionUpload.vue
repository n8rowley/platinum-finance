<script>
    export default {
        data(){return{
            bankOptions: [
                {text: '--Select Bank--', value: null, disabled: true},
                {text: 'Zions', value: 1}, 
                {text: 'Southwest', value: 2},
                {text: 'Amazon', value: 3},
            ],
            form:{
                date: null,
                account: null,
            },
            dateString: null,
        }},
        computed:{
            rearrangedDate(){
                if (!this.dateString) return;
                let pieces = this.dateString.split('/');
                return `${pieces[2]}-${pieces[0]}-${pieces[1]}`;
            }
        },
        methods:{
            onContext(ctx){
                this.form.date = ctx.yearYMD
            }
        },
    }
</script>

<template>
    <div>
        <div class="border-2 border-primary rounded-lg p-2 mb-4">
            <b-form>
                <div class="d-flex gap-x-2">
                    <b-form-group label="Bank" class="w-33">
                        <b-form-select :options="bankOptions" v-model="form.account"></b-form-select>
                    </b-form-group>
        
                    <b-form-group label="Transaction Date" class="w-33">
                        <b-input-group class="mb-3">
                            <b-form-input
                                id="example-input"
                                v-model="dateString"
                                type="text"
                                placeholder="MM/DD/YYYY"
                                autocomplete="off"
                            ></b-form-input>
                            <b-input-group-append>
                                <b-form-datepicker
                                    v-model="rearrangedDate"
                                    button-only
                                    right
                                    locale="en"
                                    aria-controls="example-input"
                                    @context="onContext"
                                ></b-form-datepicker>
                            </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                    <b-form-group label="Amount" class="w-33">
                        <b-form-input type="number"></b-form-input>
                    </b-form-group>
                </div>
                <b-form-group label="Description">
                    <b-form-input></b-form-input>
                </b-form-group>
        
            </b-form>
        </div>
        <div class="d-flex justify-content-end gap-x-2">
            <b-button>Add Transaction</b-button>
            <b-button variant="primary">Submit</b-button>
        </div>
    </div>
</template>
