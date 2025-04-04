import AppLayout from '@/layouts/app-layout'
import { type BreadcrumbItem } from '@/types'
import { Head, Link } from '@inertiajs/react'
import { Card, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import FloatingActionMenu from '@/components/floating-action-menu'
import { ArrowRight, Plus } from 'lucide-react'
import { router } from '@inertiajs/react'
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationLink,
    PaginationNext,
    PaginationPrevious,
} from "@/components/ui/pagination"

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Courts',
        href: '/dashboard/courts',
    },
]

type Court = {
    id: number,
    name: string,
    region: { name: string, parent: { name: string } },
}

export default function Courts({ courts, currentPage, nextPageUrl, prevPageUrl }: { courts: Court[], currentPage: number, nextPageUrl: string, prevPageUrl: string }) {
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
                                    <CardDescription>
                                        {court.region.name} - {court.region.parent.name}
                                    </CardDescription>
                                </CardHeader>
                            </Card>
                        )
                    })}
                </div>
                <Pagination>
                    <PaginationContent>
                        <PaginationItem>
                            <PaginationPrevious except={[]} href={prevPageUrl} />
                        </PaginationItem>
                        <PaginationItem>
                            <PaginationLink except={[]} href="#">{currentPage}</PaginationLink>
                        </PaginationItem>
                        <PaginationItem>
                            <PaginationNext except={[]} href={nextPageUrl} />
                        </PaginationItem>
                    </PaginationContent>
                </Pagination>
            </div>
        </AppLayout>
    )
}
