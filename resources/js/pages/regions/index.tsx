import AppLayout from '@/layouts/app-layout'
import { type BreadcrumbItem } from '@/types'
import { Head, Link } from '@inertiajs/react'
import { Card, CardAction, CardContent, CardFooter, CardHeader, CardTitle } from "@/components/ui/card"
import FloatingActionMenu from '@/components/floating-action-menu'
import { ArrowRight, Plus } from 'lucide-react'
import { router } from '@inertiajs/react'
import { Button } from '@/components/ui/button'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Regions',
        href: '/dashboard/regions',
    },
]

type Region = {
    id: number,
    name: string,
}

export default function Regions({ regions }: { regions: Region[] }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Regions" />
            <FloatingActionMenu options={[
                {
                    label: 'New',
                    Icon: <Plus className="w-4 h-4" />,
                    onClick: () => { router.visit('/dashboard/regions/create') },
                }
            ]} />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    {regions.map((region) => {
                        return (
                            <Card>
                                <CardHeader>
                                    <CardTitle>
                                        <Link href={`/dashboard/regions/${region.id}/edit`}>
                                            {region.name} <ArrowRight className="inline-block" />
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
