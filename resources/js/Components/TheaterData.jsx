import React, { useState, useEffect, useRef } from "react";
import DatePicker from "react-datepicker";
import Moment from 'moment';
import "react-datepicker/dist/react-datepicker.css";
import InputLabel from "./InputLabel";
import InputError from "./InputError";
import PrimaryButton from "./PrimaryButton";
import TextInput from "./TextInput";
import api from "../utils/theaterApi";

export const TheaterData = () => {
    const isFirstRender = useRef(true);
    const [startDate, setStartDate] = useState(Moment().utc().format('YYYY-MM-DD 00:00:00'));
    const [endDate, setEndDate] = useState(Moment().utc().format('YYYY-MM-DD 23:59:59'));
    const [inputError, setInputError] = useState(null);
    const [queryLimit, setQueryLimit] = useState(20);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const [warning, setWarning] = useState(null);
    const [topTheaterData, setTopTheaterData] = useState([]);
    const [showData, setShowData] = useState(false);
    const [showWarning, setShowWarning] = useState(false);
    const [showError, setShowError] = useState(false);
    const [showInfo, setShowInfo] = useState(true);
    useEffect(() => {
        if (!isFirstRender.current) {
            if (topTheaterData.length > 0) {
                // Date range was changed, hide table.
                setShowData(false);
            }

            if (Moment(endDate).isBefore(Moment(startDate))) {
                setInputError('End date cannot be earlier than the start date!');
            } else {
                setInputError(null);
            }
        }
    }, [startDate, endDate]);

    useEffect(() => {
        if (!isFirstRender.current) {

            if (topTheaterData.length > 0) {
                setShowData(true);
            }
        }
    }, [topTheaterData]);


    useEffect(() => {
        isFirstRender.current = false;
    }, []);

    const handleLimitChange = (value) => {
        setShowData(false);

        if (isNaN(parseInt(value))) {
            setInputError("Please use a numeric value as a limit.");
            setQueryLimit('');
        } else {
            setQueryLimit(value);
            setInputError(null);
        }
    };

    const getTopTheaters = async () => {
        setLoading(true);
        setShowError(false);
        setShowWarning(false);
        await api.getTopTheaters({ fromDate: startDate, toDate: endDate, queryLimit: queryLimit }).then((response) => {
            
            const {body, message } = response;

            if (message != null && message != '') {
                setError(message);
                setShowError(true);
                setLoading(false);
                return;
            }

            const data = body.data;

            if (data === undefined || data.length == 0) {
                setWarning('Empty Dataset.');
                setShowWarning(true);
                setLoading(false);
                return;
            }

            setTopTheaterData(data);
            setLoading(false);
        }).catch(() => {
            setError('Unable to return theater data. Please try again later.');
            setLoading(false);
        })
    }

    return (
        <div>
            <h1 className="mb-2">Top Theater Revenue</h1>
            {showInfo ?
                <div id="informational-banner" tabIndex="-1" className="fixed top-0 start-0 z-50 flex flex-col justify-between w-full p-4 border-b border-gray-200 md:flex-row bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                    <div className="mb-4 md:mb-0 md:me-4">
                        <h2 className="mb-1 text-base font-semibold text-gray-900 dark:text-white">Notice on data</h2>
                        <p className="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">The data displayed on this page is for demostration purposes only and does not represent any actual movie or theater sales.<br></br>Theater examples were pulled using ChatGPT and theater sales were randomly seeded.</p>
                    </div>
                    <div className="flex items-center flex-shrink-0">
                        <a href="https://github.com/CameronPeace/Cameron-App/blob/main/app/Services/OpenAiService.php#L48-L58" target="_blank" className="inline-flex items-center justify-center px-3 py-2 me-3 text-xs font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"><svg className="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M9 1.334C7.06.594 1.646-.84.293.653a1.158 1.158 0 0 0-.293.77v13.973c0 .193.046.383.134.55.088.167.214.306.366.403a.932.932 0 0 0 .5.147c.176 0 .348-.05.5-.147 1.059-.32 6.265.851 7.5 1.65V1.334ZM19.707.653C18.353-.84 12.94.593 11 1.333V18c1.234-.799 6.436-1.968 7.5-1.65a.931.931 0 0 0 .5.147.931.931 0 0 0 .5-.148c.152-.096.279-.235.366-.403.088-.167.134-.357.134-.55V1.423a1.158 1.158 0 0 0-.293-.77Z" />
                        </svg> Let me see!</a>
                        <button onClick={() => setShowInfo(false)} data-dismiss-target="#informational-banner" type="button" className="flex-shrink-0 inline-flex justify-center w-7 h-7 items-center text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg className="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span className="sr-only">Close banner</span>
                        </button>
                    </div>
                </div>
                : null}
            <div className="min-h-56 h-auto flex flex-col justify-center items-center">
                {showWarning ?
                    <div onClick={() => setShowWarning(false)} className="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                        {warning}
                    </div>
                    : null}
                {showError ?
                    <div onClick={() => setShowError(false)} className="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span className="font-medium">Error! </span>{error}
                    </div>
                    : null}
                {inputError ?
                    <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong className="font-bold">Hold up!</strong>
                        <span className="block sm:inline"> <InputError className="text-md" message={inputError} />
                        </span>
                    </div>

                    : null}
                <div className="flex flex-row justify-center items-center">
                    <div className="ml-3">
                        <InputLabel value={'Start Date'} className="mr-3 text-xl" />
                        <DatePicker selected={startDate} onChange={(date) => setStartDate(Moment(date).format('YYYY-MM-DD 00:00:00'))} />
                    </div>
                    <div className="ml-3">
                        <InputLabel value={'End Date'} className="mr-3 text-xl" />
                        <DatePicker selected={endDate} onChange={(date) => setEndDate(Moment(date).format('YYYY-MM-DD 23:59:59'))} />
                    </div>
                </div>
                <div className="flex flex-row justify-center items-center mt-5">
                    <InputLabel value={'Limit'} className="mr-3 text-xl" />
                    <TextInput type="number" min="1" value={queryLimit} placeholder={queryLimit} onInput={(event) => handleLimitChange(event.target.value)} />
                </div>
                <div className="mt-5 mb-5">
                    <PrimaryButton disabled={inputError} onClick={() => getTopTheaters()}>Search</PrimaryButton>
                </div>
                {loading ?
                    <div className="mt-5">
                        <div role="status">
                            <svg aria-hidden="true" className="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                            </svg>
                            <span className="sr-only">Loading...</span>
                        </div>
                    </div> : null}

                {showData ?
                    <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <div className="text-center mb-2">
                            <span>Showing ({topTheaterData.length}) Top Performing Theaters from {Moment(startDate).utc().format('MMMM Do YYYY')} to {Moment(endDate).utc().format('MMMM Do YYYY')}</span>
                        </div>
                        <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" className="px-6 py-3">
                                        Theater name
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Theater Address
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Revenue From Range
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {topTheaterData.map((theater) => {
                                    return (
                                        <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" key={theater.theater_id}>
                                            <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {theater.theater_name}
                                            </th>
                                            <td className="px-6 py-4">
                                                {theater.theater_street} {theater.theater_city} {theater.theater_state} {theater.theater_zip5}
                                            </td>
                                            <td className="px-6 py-4 text-center">${Number.parseFloat(theater.total_theater_sales).toFixed(2)}</td>
                                        </tr>
                                    );
                                })}
                            </tbody>
                        </table>
                    </div>
                    : null
                }
            </div>
        </div>
    );
};