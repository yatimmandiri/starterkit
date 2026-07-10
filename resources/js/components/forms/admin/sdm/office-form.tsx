import { ButtonComponent } from '@/components/partials/button-component';
import { InputTextComponent } from '@/components/partials/input-component';
import { SelectComponent } from '@/components/partials/select-component';
import offices from '@/routes/admin/sdm/offices';
import { useForm, usePage } from '@inertiajs/react';
import { SaveIcon } from 'lucide-react';
import { toast } from 'sonner';

export const OfficeForm = ({ dataId }: { dataId?: number }) => {
    const { office, types } = usePage<any>().props;

    const { data, setData, post, put, processing, errors, reset, transform } =
        useForm({
            saveBack: 'false',
            name: office?.name || '',
            address: office?.address || '',
            phone: office?.phone || '',
            email: office?.email || '',
            type: office?.type || '',
            parent_id: office?.parent?.id || '0',
        });

    // transformData
    transform((data: any) => ({
        ...data,
        ...(dataId && { _method: 'put' }),
    }));

    const handleSubmit = (e: any) => {
        e.preventDefault();

        if (dataId) {
            put(offices.update(dataId).url, {
                onSuccess: () => {
                    reset(); // reset form
                },
                onError: (errors: any) => {
                    console.log(errors);
                    toast.error('Terjadi kesalahan saat mengubah office');
                },
            });
        } else {
            post(offices.store().url, {
                onSuccess: () => {
                    reset(); // reset form
                },
                onError: () => {
                    toast.error('Terjadi kesalahan saat menambahkan office');
                },
            });
        }
    };

    return (
        <form onSubmit={handleSubmit} className="flex flex-col space-y-4">
            <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                <InputTextComponent
                    type="text"
                    label="Name"
                    name="name"
                    value={data.name}
                    handleOnChange={(value: string) => setData('name', value)}
                    errors={errors.name && errors.name}
                    helperText={errors.name && errors.name}
                />
                <InputTextComponent
                    type="text"
                    label="Address"
                    name="address"
                    value={data.address}
                    handleOnChange={(value: string) =>
                        setData('address', value)
                    }
                    errors={errors.address && errors.address}
                    helperText={errors.address && errors.address}
                />
                <InputTextComponent
                    type="text"
                    label="Phone"
                    name="phone"
                    value={data.phone}
                    handleOnChange={(value: string) => setData('phone', value)}
                    errors={errors.phone && errors.phone}
                    helperText={errors.phone && errors.phone}
                />
                <InputTextComponent
                    type="email"
                    label="Email"
                    name="email"
                    value={data.email}
                    handleOnChange={(value: string) => setData('email', value)}
                    errors={errors.email && errors.email}
                    helperText={errors.email && errors.email}
                />
                <SelectComponent
                    label="Type"
                    name="type"
                    data={types.map((item: any) => ({
                        value: item,
                        label: item,
                    }))}
                    dataSelected={data.type}
                    handleOnChange={(value: any) => setData('type', value)}
                    errors={errors.type && errors.type}
                    helperText={errors.type && errors.type}
                />
                <SelectComponent
                    label="Parent Office"
                    name="parent_id"
                    placeholder="Select Parent"
                    dataSelected={data.parent_id}
                    setDataSelected={(value: string) =>
                        setData('parent_id', value)
                    }
                    fetchDataUrl={offices.data().url}
                    selectedLabel={office?.parent?.name || ''}
                    errors={errors.parent_id && errors.parent_id}
                    helperText={errors.parent_id && errors.parent_id}
                    handleOnChange={(value: string) =>
                        setData('parent_id', value)
                    }
                />
            </div>
            <div className="flex justify-end space-x-4">
                <ButtonComponent
                    buttonText="Save"
                    addonLeft={SaveIcon}
                    buttonType="submit"
                    isProcessing={processing}
                    onClick={() => setData('saveBack', 'true')}
                />
            </div>
        </form>
    );
};
