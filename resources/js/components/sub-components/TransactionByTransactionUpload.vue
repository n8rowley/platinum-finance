<script>
    import SingleTransactionForm from './SingleTransactionForm.vue';

    export default {
        name: "TransactionByTransactionUpload",
        components: {SingleTransactionForm},
        data(){return{
            bankOptions: [
                {text: '--Select Bank--', value: null, disabled: true},
                {text: 'Zions', value: 1}, 
                {text: 'Southwest', value: 2},
                {text: 'Amazon', value: 3},
            ],
            forms:[{
                date: null,
                bank_account_id: null,
                amount: null,
                description: null,
            }],
        }},
        created(){
            axios({
                method: "GET",
                url: "/api/bankAccounts",
            }).then(({data})=>{
                this.bankOptions = data;
            })
        },
        methods:{
            submitForms(){
                axios.post('api/upload-individual-transactions',{transactions: this.forms}).then(({data})=>{
                    this.$emit('imported', data);
                    this.forms = [{
                        date: null,
                        bank_account_id: null,
                        amount: null,
                        description: null,
                    }];
                });
            },
            addForm(){
                this.forms.push({
                    date: null,
                    bankd_account_id: null,
                    amount: null,
                    description: null,
                });
            },
            transactionInputHandler(index,data){
                this.forms[index] = data;
            }
        },
    }
</script>

<template>
    <div>
        <div v-for="(n,index) in forms.length" :key="index" class="border-2 border-primary rounded-lg p-2 mb-4 position-relative">
            <single-transaction-form :value="forms[index]" @input="transactionInputHandler(index,$event)" :bankOptions="bankOptions"/>
            <b-icon v-if="index > 0" icon="x-lg" class="position-absolute" style="top: .5em; right: .5em" @click="forms.splice(index,1)"></b-icon>
        </div>
        <div class="d-flex justify-content-end gap-x-2">
            <b-button @click="addForm">Add Transaction</b-button>
            <b-button variant="primary" @click="submitForms">Submit</b-button>
        </div>
    </div>
</template>
