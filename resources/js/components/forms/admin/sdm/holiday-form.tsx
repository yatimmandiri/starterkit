import { ButtonComponent } from '@/components/partials/button-component';
import { DatePickerComponent } from '@/components/partials/datePicker-component';
import { InputTextComponent } from '@/components/partials/input-component';
import holidays from '@/routes/admin/sdm/holidays';
import { useForm, usePage } from '@inertiajs/react';
import { SaveIcon } from 'lucide-react';
import { toast } from 'sonner';

export const HolidayForm = ({ dataId }: { dataId?: number }) => {
    const { holiday, workTypes, types } = usePage<any>().props;

    const { data, setData, post, put, processing, errors, reset, transform } =
        useForm({
            saveBack: 'false',
            name: holiday?.name || '',
            date: holiday?.date || '',
            description: holiday?.description || '',
        });

    // transformData
    transform((data: any) => ({
        ...data,
        ...(dataId && { _method: 'put' }),
    }));

    const handleSubmit = (e: any) => {
        e.preventDefault();

        if (dataId) {
            put(holidays.update(dataId).url, {
                onSuccess: () => {
                    reset(); // reset form
                },
                onError: (errors: any) => {
                    console.log(errors);
                    toast.error('Terjadi kesalahan saat mengubah holiday');
                },
            });
        } else {
            post(holidays.store().url, {
                onSuccess: () => {
                    reset(); // reset form
                },
                onError: () => {
                    toast.error('Terjadi kesalahan saat menambahkan holiday');
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
                <DatePickerComponent
                    label="Date"
                    name="date"
                    value={data.date}
                    handleOnChange={(value: string) => setData('date', value)}
                    errors={errors.date && errors.date}
                    helperText={errors.date && errors.date}
                />
                <InputTextComponent
                    type="text"
                    label="Description"
                    name="description"
                    value={data.description}
                    handleOnChange={(value: string) =>
                        setData('description', value)
                    }
                    errors={errors.description && errors.description}
                    helperText={errors.description && errors.description}
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
