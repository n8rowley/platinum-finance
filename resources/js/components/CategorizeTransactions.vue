<template>
    <div>
        <div v-if="oldestTransaction">
            <div class="px-4 py-2 bg-secondary text-dark rounded-lg text-lg mb-2">
                <div class="d-flex justify-content-between align-items-center gap-x-2" style="line-height: 1em;">
                    <div>{{ oldestTransaction.id }}</div>
                    <div> | </div>
                    <div class="flex-grow-1">{{ oldestTransaction.description }}</div>
                    <div> | </div>
                    <div class="text-center">{{ oldestTransaction.bank_account.name }}</div>
                    <div> | </div>
                    <div class="text-center">{{ (new Date(oldestTransaction.date)).toLocaleDateString() }}</div>
                    <div> | </div>
                    <div class="text-center flex-shrink-0">$ {{ oldestTransaction.amount }}</div>
                </div>
            </div>
            <CategorizeTransactrionsEntry v-for="(_,index) in form.length" v-model="form[index]" :key="`${oldestTransaction.id}-${index}`" :categories="categories" :subDivideAmount="form.length > 1"/>
            <div class="d-flex gap-x-2">
                <fetch-feedback ref="feedback" class="flex-grow-1"></fetch-feedback>
                <b-button @click="patchDuplicate">Mark Duplicate</b-button>
                <b-button @click="addTransaction">Split Transaction</b-button>
                <b-button variant="primary" @click="postExpenses">Submit</b-button>
            </div>
        </div>
        <div v-else>No un-categorized transactions</div>
    </div>
</template>

<script>
import FetchFeedback from './sub-components/FetchFeedback.vue';
import CategorizeTransactrionsEntry from './CategorizeTransactrionsEntry.vue';

export default {
    name: "assign-categories",
    components: { FetchFeedback, CategorizeTransactrionsEntry },
    data(){return{
        form: [],
        oldestTransaction: null,
        categories: [],
    }},
    created(){
        this.fetchTransaction();
        this.fetchCategories();
    },
    methods: {
        async fetchTransaction(){
            let response = await axios.get('/api/transactions/oldest');
            let transaction = response['data'];

            this.oldestTransaction = transaction;
            this.form = [{
                description: transaction.description,
                month: transaction.date,
                sub_category_id: null,
                amount: transaction.amount,
            }];
        },
        async fetchCategories(){
            let response = await axios.get('/api/categories');
            this.categories = response['data'];
        },
        addTransaction(){
            this.form = [
                ...this.form,
                {
                    description: null,
                    month: this.oldestTransaction.date,
                    sub_category_id: null,
                    amount: 0,
                },
            ]
        },
        postExpenses(){
            if (this.form.reduce((sum, expense)=>sum + Number(expense.amount),0) != this.oldestTransaction.amount){
                this.$refs.feedback.error({message: "Expense amounts do not add up"});
                return;
            }

            axios.post(`api/expenses/by-transaction/${this.oldestTransaction.id}`, {
                expenses: this.form,
            })
            .then(()=>{
                this.$refs.feedback.success({message: `Transaction processed`});
            })
            .then(this.fetchTransaction)
            .catch(({response})=>{
                this.$refs.feedback.error(response);
            });
        },
        patchDuplicate(){
            axios.patch(`/api/transactions/${this.oldestTransaction.id}`,{
                duplicate: true,
                processed: true,
            }).then(this.fetchTransaction)
            .catch(({response})=>{
                this.$refs.feedback.error(response);
            });
        }
    }
}
</script>
