import { ButtonComponent } from '@/components/partials/button-component';
import { InputTextComponent } from '@/components/partials/input-component';
import { SelectComponent } from '@/components/partials/select-component';
import positions from '@/routes/admin/sdm/positions';
import { useForm, usePage } from '@inertiajs/react';
import { SaveIcon } from 'lucide-react';
import { toast } from 'sonner';

export const PositionForm = ({ dataId }: { dataId?: number }) => {
    const { position, workTypes, types } = usePage<any>().props;

    const { data, setData, post, put, processing, errors, reset, transform } =
        useForm({
            saveBack: 'false',
            name: position?.name || '',
            office_type: position?.office_type || '',
            work_type: position?.work_type || '',
            parent_id: position?.parent?.id || '0',
        });

    // transformData
    transform((data: any) => ({
        ...data,
        ...(dataId && { _method: 'put' }),
    }));

    const handleSubmit = (e: any) => {
        e.preventDefault();

        if (dataId) {
            put(positions.update(dataId).url, {
                onSuccess: () => {
                    reset(); // reset form
                },
                onError: (errors: any) => {
                    console.log(errors);
                    toast.error('Terjadi kesalahan saat mengubah position');
                },
            });
        } else {
            post(positions.store().url, {
                onSuccess: () => {
                    reset(); // reset form
                },
                onError: () => {
                    toast.error('Terjadi kesalahan saat menambahkan position');
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
                <SelectComponent
                    label="Office Type"
                    name="office_type"
                    data={types.map((item: any) => ({
                        value: item,
                        label: item,
                    }))}
                    dataSelected={data.office_type}
                    handleOnChange={(value: any) =>
                        setData('office_type', value)
                    }
                    errors={errors.office_type && errors.office_type}
                    helperText={errors.office_type && errors.office_type}
                />
                <SelectComponent
                    label="Work Type"
                    name="work_type"
                    data={workTypes.map((item: any) => ({
                        value: item,
                        label: item,
                    }))}
                    dataSelected={data.work_type}
                    handleOnChange={(value: any) => setData('work_type', value)}
                    errors={errors.work_type && errors.work_type}
                    helperText={errors.work_type && errors.work_type}
                />
                <SelectComponent
                    label="Parent Position"
                    name="parent_id"
                    placeholder="Select Parent"
                    dataSelected={data.parent_id}
                    setDataSelected={(value: string) =>
                        setData('parent_id', value)
                    }
                    fetchDataUrl={positions.data().url}
                    selectedLabel={position?.parent?.name || ''}
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
