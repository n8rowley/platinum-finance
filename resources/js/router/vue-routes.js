import WelcomeContent from '../components/WelcomeContent';
import MonthlyBreakdown from '../components/MonthlyBreakdown';
import StatementUpload from '../components/StatementUpload';

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
];