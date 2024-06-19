<template>
    <div>
        <h2 class="tw-text-xl">Transaction {{ transaction.id }}</h2>
        <div>{{ transaction.description }}</div>
        <div class="tw-flex tw-space-x-4">
            <div>{{ (new Date(transaction.date + "T00:00")).toDateString() }}</div>
            <div>{{ transaction.bank_account.name }}</div>
            <div>{{ transaction.amount }}</div>
        </div>
        <div class="tw-mt-8">
            <h3>Expenses</h3>
            <ul class="tw-list-disc tw-list-inside">
                <li v-for="expense in transaction.expenses" :key="expense.id" class="tw-space-x-4">
                    <span>{{ expense.description }}</span>
                    <span>{{ expense.sub_category.category.name }}</span>
                    <span>{{ expense.sub_category.name }}</span>
                    <span>{{ expense.amount }}</span>
                    <span>{{ expense.month }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "show",
        props: {
            id: {
                type: [Number, String],
                required: true,
            },
        },
        data(){return{
            transaction: {},
        }},
        created(){
            this.getTransaction();
        },
        methods: {
            getTransaction(){
                axios.get('/api/transactions/' + this.id)
                    .then(({data})=>{
                        this.transaction = data;
                    })
                    .catch((error)=>{
                        console.dir(error);
                    });
            }
        }
    }
</script>
