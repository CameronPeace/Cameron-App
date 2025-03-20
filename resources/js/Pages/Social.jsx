import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import SocialSelector from '../Components/Social/SocialSelector'
export default function Social({ auth }) {

    const [events, setEvents] = useState([]);

    useEffect(() => {
        console.log('Loading initial data.');
        setEvents([{ type: 'youtube' }, { type: 'youtube' }]);
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Social Feed</h2>}
        >
            <Head title="Top Theaters" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div>
                            <h1>Social Feed</h1>
                            <>
                                {events.map(event => (<SocialSelector type={event.type}/>))}
                            </>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
