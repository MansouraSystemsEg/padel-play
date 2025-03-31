import AppLayout from '@/layouts/app-layout'
import { type BreadcrumbItem } from '@/types'
import { Head, Link } from '@inertiajs/react'
import { Card, CardHeader, CardTitle } from "@/components/ui/card"
import FloatingActionMenu from '@/components/floating-action-menu'
import { ArrowRight, Plus } from 'lucide-react'
import { router } from '@inertiajs/react'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Courts',
        href: '/dashboard/courts',
    },
]

type Court = {
    id: number,
    name: string,
}

export default function Courts({ courts }: { courts: Court[] }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Courts" />
            <FloatingActionMenu options={[
                {
                    label: 'New',
                    Icon: <Plus className="w-4 h-4" />,
                    onClick: () => { router.visit('/dashboard/courts/create') },
                }
            ]} />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    {courts.map((court) => {
                        return (
                            <Card>
                                <CardHeader>
                                    <CardTitle>
                                        <Link href={`/dashboard/courts/${court.id}/edit`}>
                                            {court.name} <ArrowRight className="inline-block" />
                                        </Link>
                                    </CardTitle>
                                </CardHeader>
                            </Card>
                        )
                    })}
                </div>
            </div>
        </AppLayout>
    )
}
