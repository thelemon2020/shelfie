import React, {useEffect, useState} from 'react';
import {QueryClient, QueryClientProvider, useQuery} from "react-query";
import {
    Center,
    Footer,
    Image,
    LoadingOverlay,
    NativeSelect,
    Pagination,
    Space,
    Table,
    TextInput,
    Title
} from "@mantine/core";
import {useModals} from '@mantine/modals'
import {DetailsModalWithProvider} from "../DetailsModal";
import {useEnvState} from "../Context/EnvStateContext";

const queryClient = new QueryClient();

export default function CollectionSection() {
    return (
        <QueryClientProvider client={queryClient}>
            <Collection/>
        </QueryClientProvider>
    );
}

const Collection = () => {
    const [search, setSearch] = useState('');
    const [sort, setSort] = useState('artist');
    const [paginate, setPaginate] = useState(50);
    const [activePage, setPage] = useState(1);
    const [rows, setRows] = useState(<></>)

    const modals = useModals();
    const {isLoading, error, data} = useQuery(['releases', {search, sort, paginate, activePage}], () =>
        fetch(`http://127.0.0.1:8000/api/releases?search=${search}&sort=${sort}&paginate=${paginate}&page=${activePage}`).then(res =>
            res.json()
        ));

    const { innerWidth: width, innerHeight: height } = window;
    console.log('width', width, 'innerheight', height)

    const env = useEnvState()
    console.log('env', env)


    const openDetailsModal = (releaseId) => {
        const id = modals.openModal({
            title: 'Record Details',
            // className:'raspi:h-1/6 h-2/4  raspi:w-screen w-1/4',
            size: height === 480 && width === 800 ? '100%' : 'lg',
            children: (
                <DetailsModalWithProvider closeModal={() => modals.closeModal(id)} releaseId={releaseId}/>
            ),
        });
    }
    useEffect(() => {
        setRows(data?.data?.map((element) => {
            return (
                <tr key={element?.id}>
                    <td><Image src={element?.full_image} height={200} width={200} alt="Album Cover"
                               onClick={() => openDetailsModal(element?.id)}/></td>
                    <td style={{textAlign: "center"}}>{element.artist}</td>
                    <td style={{textAlign: "center"}}>{element.title}</td>
                    <td>
                        <div style={{textAlign: "center"}}>
                            <Title order={4}>Primary Genres</Title>
                            {element.genres?.map((genre) => {
                                return genre.name
                            }).join(', ')}
                            <Title order={4}>Secondary Genres</Title>
                            {element.subgenres?.map((genre) => {
                                return genre.name
                            }).join(', ')}
                        </div>
                    </td>
                </tr>
            )
        }));
    }, [data])

    return (
        <div>
            <div style={{display: 'flex', flexDirection: 'row'}}>
                <TextInput value={search} onChange={(event) => setSearch(event.currentTarget.value)}
                           placeholder="Search"/>
                <Space w="xs"/>
                <NativeSelect data={['Artist', 'Title', 'Genre']} value={sort}
                              onChange={(event) => setSort(event.currentTarget.value)}/>
            </div>
            <Table verticalSpacing="xl">
                <thead>
                <tr>
                    <th/>
                    <th style={{textAlign: "center"}}>Artist</th>
                    <th style={{textAlign: "center"}}>Title</th>
                    <th style={{textAlign: "center"}}>Genres</th>
                </tr>
                </thead>
                <tbody>{isLoading ? <LoadingOverlay visible={true}/> : rows}</tbody>
            </Table>
            <Footer height={50}><Center><Pagination style={{marginTop: 10}} page={activePage} onChange={setPage}
                                                    total={data?.last_page}/></Center></Footer>
        </div>
    )
        ;
}
