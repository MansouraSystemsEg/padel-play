import { type BreadcrumbItem, type SharedData } from '@/types'
import { Transition } from '@headlessui/react'
import { router, Head, useForm } from '@inertiajs/react'
import { FormEventHandler } from 'react'

import InputError from '@/components/input-error'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import AppLayout from '@/layouts/app-layout'

import HeadingSmall from '@/components/heading-small'

import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogTitle, DialogTrigger } from '@/components/ui/dialog'
import { Select, SelectContent, SelectItem, SelectValue } from '@/components/ui/select'
import { SelectTrigger } from '@radix-ui/react-select'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Courts',
        href: '/dashboard/courts',
    },
]

type Region = {
    id: number
    name: string
}

type Court = {
    id: number
    name: string
    region_id: string
}

type CourtForm = {
    name: string
    region_id: string
}

export default function Court({ court, regions }: { court?: Court, regions: Region[] }) {
    const { data, setData, post, put, errors, processing, recentlySuccessful } = useForm<Partial<CourtForm>>(court)

    const submit: FormEventHandler = (e) => {
        e.preventDefault()

        if (court) {
            put(route('courts.update', { id: court.id }), {
                preserveScroll: true,
            })
        } else {
            post(route('courts.store'), {
                preserveScroll: true,
            })
        }
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs.concat([{ title: court?.name || 'Create New Court', href: court ? `/dashboard/courts/${court.id}/edit` : "/courts/create" }])}>
            <Head title={court?.name || 'New Court'} />

            <div className="px-4 py-6">
                <div className="space-y-6">
                    <HeadingSmall title="Court information" />
                    <form onSubmit={submit} className="space-y-6">
                        <div className="grid gap-2">
                            <Label htmlFor="name">Name</Label>

                            <Input
                                id="name"
                                className="mt-1 block w-full"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                required
                                autoComplete="name"
                                placeholder="Name"
                            />

                            <InputError className="mt-2" message={errors.name} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="name">Region</Label>

                            <Select onValueChange={(value) => setData('region_id', value)} defaultValue={court ? `${court?.region_id}` : undefined}>
                                <SelectTrigger className="w-[180px]">
                                    <SelectValue placeholder="Region" />
                                </SelectTrigger>
                                <SelectContent>
                                    {regions.map((region) => {
                                        return (
                                            <SelectItem key={region.id} value={`${region.id}`}>{region.name}</SelectItem>
                                        )
                                    })}
                                </SelectContent>
                            </Select>

                            <InputError className="mt-2" message={errors.name} />
                        </div>

                        <div className="flex items-center gap-4">
                            <Button disabled={processing}>Save</Button>

                            <Transition
                                show={recentlySuccessful}
                                enter="transition ease-in-out"
                                enterFrom="opacity-0"
                                leave="transition ease-in-out"
                                leaveTo="opacity-0"
                            >
                                <p className="text-sm text-neutral-600">Saved</p>
                            </Transition>
                        </div>
                    </form>
                    {court && <DeleteCourt court={court} />}
                </div>
            </div>
        </AppLayout>
    )
}

function DeleteCourt({ court }: { court: Court }) {
    const { data, setData, delete: destroy, processing, reset, errors, clearErrors } = useForm<Required<{}>>()

    const deleteCourt: FormEventHandler = (e) => {
        e.preventDefault()

        destroy(route('courts.destroy', { id: court.id }), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onFinish: () => router.visit('/dashboard/courts'),
        })
    }

    const closeModal = () => {
        clearErrors()
        reset()
    }

    return (
        <div className="space-y-6">
            <HeadingSmall title="Delete court" description="Delete this court and all of its resources" />
            <div className="space-y-4 rounded-lg border border-red-100 bg-red-50 p-4 dark:border-red-200/10 dark:bg-red-700/10">
                <div className="relative space-y-0.5 text-red-600 dark:text-red-100">
                    <p className="font-medium">Warning</p>
                    <p className="text-sm">Please proceed with caution, this cannot be undone.</p>
                </div>

                <Dialog>
                    <DialogTrigger asChild>
                        <Button variant="destructive">Delete court</Button>
                    </DialogTrigger>
                    <DialogContent>
                        <DialogTitle>Are you sure you want to delete this court?</DialogTitle>
                        <DialogDescription>
                            Once this court is deleted, all of its resources and data will not be accessible to all users.
                        </DialogDescription>
                        <form className="space-y-6" onSubmit={deleteCourt}>
                            <DialogFooter className="gap-2">
                                <DialogClose asChild>
                                    <Button variant="secondary" onClick={closeModal}>
                                        Cancel
                                    </Button>
                                </DialogClose>

                                <Button variant="destructive" disabled={processing} asChild>
                                    <button type="submit">Delete court</button>
                                </Button>
                            </DialogFooter>
                        </form>
                    </DialogContent>
                </Dialog>
            </div>
        </div>
    )
}