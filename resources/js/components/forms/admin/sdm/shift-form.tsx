import { ButtonComponent } from '@/components/partials/button-component';
import { InputTextComponent } from '@/components/partials/input-component';
import shifts from '@/routes/admin/sdm/shifts';
import { useForm, usePage } from '@inertiajs/react';
import { SaveIcon } from 'lucide-react';
import { toast } from 'sonner';

export const ShiftForm = ({ dataId }: { dataId?: number }) => {
    const { shift, workTypes, types } = usePage<any>().props;

    const { data, setData, post, put, processing, errors, reset, transform } =
        useForm({
            saveBack: 'false',
            name: shift?.name || '',
            start_time: shift?.start_time || '',
            end_time: shift?.end_time || '',
        });

    // transformData
    transform((data: any) => ({
        ...data,
        ...(dataId && { _method: 'put' }),
    }));

    const handleSubmit = (e: any) => {
        e.preventDefault();

        if (dataId) {
            put(shifts.update(dataId).url, {
                onSuccess: () => {
                    reset(); // reset form
                },
                onError: (errors: any) => {
                    console.log(errors);
                    toast.error('Terjadi kesalahan saat mengubah shift');
                },
            });
        } else {
            post(shifts.store().url, {
                onSuccess: () => {
                    reset(); // reset form
                },
                onError: () => {
                    toast.error('Terjadi kesalahan saat menambahkan shift');
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
                    type="time"
                    label="Start Time"
                    name="start_time"
                    value={data.start_time}
                    handleOnChange={(value: string) =>
                        setData('start_time', value)
                    }
                    errors={errors.start_time && errors.start_time}
                    helperText={errors.start_time && errors.start_time}
                />
                <InputTextComponent
                    type="time"
                    label="End Time"
                    name="end_time"
                    value={data.end_time}
                    handleOnChange={(value: string) =>
                        setData('end_time', value)
                    }
                    errors={errors.end_time && errors.end_time}
                    helperText={errors.end_time && errors.end_time}
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
