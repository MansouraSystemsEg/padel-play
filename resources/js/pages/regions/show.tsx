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

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Regions',
        href: '/dashboard/regions',
    },
]

type Region = {
    id: number
    name: string
}

type RegionForm = {
    name: string
}

export default function Region({ region }: { region?: Region }) {
    const { data, setData, post, put, errors, processing, recentlySuccessful } = useForm<Partial<RegionForm>>(region)

    const submit: FormEventHandler = (e) => {
        e.preventDefault()

        if (region) {
            put(route('regions.update', { id: region.id }), {
                preserveScroll: true,
            })
        } else {
            post(route('regions.store'), {
                preserveScroll: true,
            })
        }
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs.concat([{ title: region?.name || 'Create New Region', href: region ? `/dashboard/regions/${region.id}/edit` : "/dashboard/regions/create" }])}>
            <Head title={region?.name || 'New Region'} />

            <div className="px-4 py-6">
                <div className="space-y-6">
                    <HeadingSmall title="Region information" />
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
                    {region && <DeleteRegion region={region} />}
                </div>
            </div>
        </AppLayout>
    )
}

function DeleteRegion({ region }: { region: Region }) {
    const { data, setData, delete: destroy, processing, reset, errors, clearErrors } = useForm<Required<{}>>()

    const deleteRegion: FormEventHandler = (e) => {
        e.preventDefault()

        destroy(route('regions.destroy', { id: region.id }), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onFinish: () => router.visit('/dashboard/regions'),
        })
    }

    const closeModal = () => {
        clearErrors()
        reset()
    }

    return (
        <div className="space-y-6">
            <HeadingSmall title="Delete region" description="Delete this region and all of its resources" />
            <div className="space-y-4 rounded-lg border border-red-100 bg-red-50 p-4 dark:border-red-200/10 dark:bg-red-700/10">
                <div className="relative space-y-0.5 text-red-600 dark:text-red-100">
                    <p className="font-medium">Warning</p>
                    <p className="text-sm">Please proceed with caution, this cannot be undone.</p>
                </div>

                <Dialog>
                    <DialogTrigger asChild>
                        <Button variant="destructive">Delete region</Button>
                    </DialogTrigger>
                    <DialogContent>
                        <DialogTitle>Are you sure you want to delete this region?</DialogTitle>
                        <DialogDescription>
                            Once this region is deleted, all of its resources and data will not be accessible to all users.
                        </DialogDescription>
                        <form className="space-y-6" onSubmit={deleteRegion}>
                            <DialogFooter className="gap-2">
                                <DialogClose asChild>
                                    <Button variant="secondary" onClick={closeModal}>
                                        Cancel
                                    </Button>
                                </DialogClose>

                                <Button variant="destructive" disabled={processing} asChild>
                                    <button type="submit">Delete region</button>
                                </Button>
                            </DialogFooter>
                        </form>
                    </DialogContent>
                </Dialog>
            </div>
        </div>
    )
}