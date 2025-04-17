import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { TestComponent } from '../Components/TestComponent';

export default function Test({ auth }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Test Page</h2>}
        >
            <Head title="Test Page" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <TestComponent/>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
