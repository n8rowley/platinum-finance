import WelcomeContent from '../components/WelcomeContent';
import MonthlyBreakdown from '../components/MonthlyBreakdown';

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
    }
];