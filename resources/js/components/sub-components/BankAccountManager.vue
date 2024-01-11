<script>
import EditableCategory from './EditableCategory.vue';

export default {
    name: "bank-account-manager",
    components: { EditableCategory },
    props:{},
    data(){return {
        bankAccounts: [
            {
                id: 3,
                name: "Zions", 
                mapping: {
                    headerLines: 3,
                    date: 0,
                    description: 1,
                    amount: 4,
                    amount2: 5,
                    splitAmount: true,
                },
                enabled: true,
            },
            {
                id: 2,
                name: "Southwest",
                mapping: {
                    headerLines: 2,
                    date: 1,
                    description: 3,
                    amount: 5,
                    splitAmount: false,
                },
                enabled: true,
            },
            {
                id: 1,
                name: "Discover",
                mapping: {
                    headerLines: 2,
                    date: 1,
                    description: 3,
                    amount: 5,
                    splitAmount: false,
                },
                enabled: false,
            }
        ],
        activeBank: {},
        showDisabled: false,
    }},
    computed: {
        enabledBankAccounts(){
            return this.bankAccounts.filter((item)=>item.enabled);
        },
        disabledBankAccounts(){
            return this.bankAccounts.filter((item)=>!item.enabled);
        },
        activeMapping(){
            return this.activeBank.has_statement_map ? this.activeBank.statement_map : null;
        },
        accountIsSelected(){
            return Object.keys(this.activeBank).length !== 0;
        }
    },
    created(){
        axios({
            method: "GET",
            url: "/api/bankAccounts"
        }).then(({data})=>{
            this.bankAccounts = data;
        })
    },
    methods: {
        insertBankAccount(){
            this.bankAccounts = [
                ...this.bankAccounts,
                {
                    id: this.bankAccounts.length * -1,
                    name: null, 
                    enabled: true, 
                    has_statement_map: false,
                },
            ]
        },
        addStatementMap(account){
            this.$set(account,'statement_map',{header_lines: null,date_column:null,description_column:null,amount_is_split:false,amount_column:null,amount_2_column:null});
            this.$set(account,'has_statement_map',true);
        },
        updateAccount(id,payload){
            axios({
                method: "PUT",
                url: "/api/bankAccounts/" + id,
                data: payload,
            }).then(({data})=>{
                let index = this.bankAccounts.findIndex(account=>account.id == data.id);
                this.$set(this.bankAccounts,index,data);
            });
        },
        createAccount(payload){
            console.log(payload);
            axios({
                method: "POST",
                url: "/api/bankAccounts",
                data: payload,
            }).then(({data})=>{
                //TODO: there's a bug here that doesn't update the id on the local copy
                console.log('payload.id:', payload);
                let index = this.bankAccounts.findIndex(account=>account.id == payload.id);
                console.log('index:', index),
                this.$set(this.bankAccounts,index,data);
            });
        },
        saveAccount(id, data){
            if (id > 0) this.updateAccount(id,data);
            else this.createAccount(this.bankAccounts.find(account=>account.id == id));
        }
    },
}
</script>

<template>
    <div class="p-4 d-flex">
        <div class="w-33 d-flex flex-column gap-y-2 pr-4 border-right border-dark">
            <editable-category v-for="bank in enabledBankAccounts" :key="bank.id" :value="bank" :active="activeBank.id == bank.id" @clicked="activeBank = bank" @saved="saveAccount(bank.id,$event)"></editable-category>
            <div class="rounded-pill border border-accent bg-accent text-dark px-4 py-2 cursor-pointer active-bg-filter" @click="insertBankAccount">Add new bank +</div>
            <b-button variant="link" @click="showDisabled = !showDisabled">{{showDisabled ? 'Hide' : 'View'}} Inactive Bank Accounts</b-button>
            <b-collapse v-model="showDisabled">
                <div class="d-flex flex-column gap-y-2">
                    <editable-category v-for="bank in disabledBankAccounts" :key="bank.id" :value="bank" :active="activeBank.id == bank.id" @clicked="activeBank = bank" @saved="saveAccount(bank.id,$event)"></editable-category>
                </div>
            </b-collapse>
        </div>
        <div v-if="accountIsSelected" class="flex-grow-1 pl-4">
            <div v-if="activeBank.has_statement_map">
                <b-form class="gap-x-4" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr));">
                    <b-form-group label="Header Lines">
                        <b-form-input type="number" v-model="activeMapping.header_lines"></b-form-input>
                    </b-form-group>
                    <b-form-group label="Date Column">
                        <b-form-input type="number" v-model="activeMapping.date_column"></b-form-input>
                    </b-form-group>
                    <b-form-group label="Description Column">
                        <b-form-input type="number" v-model="activeMapping.description_column"></b-form-input>
                    </b-form-group>
                    <b-form-checkbox v-model="activeMapping.amount_is_split">Deposit and Withdrawal are split</b-form-checkbox>
                    <b-form-group label="Amount Column">
                        <b-form-input type="number" v-model="activeMapping.amount_column"></b-form-input>
                    </b-form-group>
                    <b-form-group label="Amount 2 Column" :disabled="!activeMapping.amount_is_split">
                        <b-form-input type="number" v-model="activeMapping.amount_2_column"></b-form-input>
                    </b-form-group>
                </b-form>
                <b-button pill variant="accent" @click="updateAccount(activeBank.id,{'statement_map':activeMapping})">Save</b-button>
            </div>
            <div v-else><b-button :disabled="activeBank.id < 0" pill variant="accent" @click="addStatementMap(activeBank)">Add statement map + </b-button></div>
        </div>
    </div>
</template>
