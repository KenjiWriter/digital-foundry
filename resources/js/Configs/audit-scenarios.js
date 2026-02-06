export const auditScenarios = [
    {
        id: 'ecommerce',
        label: 'E-commerce & Retail',
        icon: 'ShoppingBagIcon',
        painPoints: [
            {
                id: 'returns_processing',
                label: 'Processing Returns',
                description: 'Validating items, restocking, and issuing refunds manually.',
                question: 'How many returns do you process monthly?',
                metric: {
                    id: 'monthly_returns',
                    unit: 'returns',
                    step: 10,
                    min: 10,
                    max: 10000,
                    defaultValue: 50
                },
                impact: {
                    minutesSavedPerUnit: 15, // 15 mins per return automated
                    errorRate: 0.05 // 5% error rate reduction
                }
            },
            {
                id: 'support_tickets',
                label: 'Customer Support Tickets',
                description: 'Answering duplicate questions about order status.',
                question: 'How many support tickets do you handle monthly?',
                metric: {
                    id: 'monthly_tickets',
                    unit: 'tickets',
                    step: 50,
                    min: 50,
                    max: 50000,
                    defaultValue: 200
                },
                impact: {
                    minutesSavedPerUnit: 8, // 8 mins per ticket automated
                }
            }
        ]
    },
    {
        id: 'logistics',
        label: 'Logistics & Supply Chain',
        icon: 'TruckIcon',
        painPoints: [
            {
                id: 'manual_waybill',
                label: 'Manual Waybill Entry',
                description: 'Typing addresses and package weights into carrier portals.',
                question: 'How many shipments do you dispatch monthly?',
                metric: {
                    id: 'monthly_shipments',
                    unit: 'shipments',
                    step: 100,
                    min: 100,
                    max: 100000,
                    defaultValue: 500
                },
                impact: {
                    minutesSavedPerUnit: 12, // 12 mins per shipment
                }
            },
            {
                id: 'inventory_sync',
                label: 'Inventory Sync Errors',
                description: 'Fixing stock discrepancies between warehouse and sales channels.',
                question: 'How many inventory discrepancy events occur monthly?',
                metric: {
                    id: 'monthly_sync_errors',
                    unit: 'errors',
                    step: 1,
                    min: 1,
                    max: 1000,
                    defaultValue: 10
                },
                impact: {
                    minutesSavedPerUnit: 45, // 45 mins to resolve one error
                }
            }
        ]
    },
    {
        id: 'service_agency',
        label: 'Service Agency (B2B)',
        icon: 'BriefcaseIcon',
        painPoints: [
            {
                id: 'client_onboarding',
                label: 'Client Onboarding',
                description: 'Manual contract generation, folder setup, and access sharing.',
                question: 'How many new clients do you onboard monthly?',
                metric: {
                    id: 'monthly_clients',
                    unit: 'clients',
                    step: 1,
                    min: 1,
                    max: 100,
                    defaultValue: 4
                },
                impact: {
                    minutesSavedPerUnit: 90, // 1.5 hours per client
                }
            },
            {
                id: 'reporting',
                label: 'Monthly Reporting',
                description: 'Gathering data and creating PDF reports for clients manually.',
                question: 'How many reports do you generate monthly?',
                metric: {
                    id: 'monthly_reports',
                    unit: 'reports',
                    step: 5,
                    min: 5,
                    max: 500,
                    defaultValue: 20
                },
                impact: {
                    minutesSavedPerUnit: 60, // 1 hour per report
                }
            }
        ]
    }
];
