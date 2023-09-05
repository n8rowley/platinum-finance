import WelcomeContent from '../components/WelcomeContent';
import MonthlyBreakdown from '../components/MonthlyBreakdown';
import StatementUpload from '../components/StatementUpload';
import CategorizeTransactions from '../components/CategorizeTransactions';
import UserSettings from '../components/UserSettings';

export const routes = [
    {
        path: '',
        name: 'welcome',
        component: WelcomeContent,
    },
    {
        path: '/monthly-breakdown',
        name: 'monthly-breakdown',
        component: MonthlyBreakdown,
    },
    {
        path: '/statement-upload',
        name: 'statement-upload',
        component: StatementUpload,
    },
    {
        path: '/categorize-transactions',
        name: 'categorize-transactions',
        component: CategorizeTransactions,
    },
    {
        path: '/settings',
        name: 'settings',
        component: UserSettings,
    },
];