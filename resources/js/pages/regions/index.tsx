import AppLayout from '@/layouts/app-layout'
import { type BreadcrumbItem } from '@/types'
import { Head, Link } from '@inertiajs/react'
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import FloatingActionMenu from '@/components/floating-action-menu'
import { ArrowRight, Plus } from 'lucide-react'
import { router } from '@inertiajs/react'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Regions',
        href: '/dashboard/regions',
    },
]

type Region = {
    id: number,
    name: string,
    manager?: { id: number, name: string }
    children: Region[],
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
                            <Card key={region.id} className="col-span-3">
                                <CardHeader>
                                    <CardTitle>
                                        <Row region={region} />
                                    </CardTitle>
                                </CardHeader>
                                <CardContent className="flex flex-col gap-2">
                                    {region.children.map((region) => {
                                        return (
                                            <Row key={region.id} region={region} />
                                        )
                                    })}
                                </CardContent>
                            </Card>
                        )
                    })}
                </div>
            </div>
        </AppLayout>
    )
}

function Row({ region }: { region: Region }) {
    return (
        <Link href={`/dashboard/regions/${region.id}/edit`} className="flex gap-4">
            {region.name}
            <ArrowRight className="ms-auto inline-block" />
        </Link>
    )
}
