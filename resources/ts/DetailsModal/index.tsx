import React from 'react';
import {Button, Grid, Image, Text, Title} from '@mantine/core';
import {QueryClient, QueryClientProvider, useQuery} from "react-query";
import {Loader} from "tabler-icons-react";

const queryClient = new QueryClient();


export const DetailsModal = ({closeModal, releaseId}) => {
    const {isLoading, error, data} = useQuery('release', () =>
        fetch('http://127.0.0.1:8000/api/release/' + releaseId).then(res =>
            res.json()
        )
    )
    return (
        <>
            {isLoading ? <Loader/> :
                <>
                    <Grid justify="center">
                        <Grid.Col span={4}>
                            <Image src={data?.full_image}/>
                        </Grid.Col>
                        <Grid.Col span={4}>
                            <Title order={4}>Artist</Title>
                            <Text align='left'>{data?.artist}</Text>
                            <Title order={4}>Title</Title>
                            <Text align='left'>{data?.title}</Text>
                            <Title order={4}>Genres</Title>
                            <Title order={5}>Primary</Title>
                            {data.genres?.map((genre) => {
                                return genre.name
                            }).join(', ')}
                            <Title order={4}>Secondary</Title>
                            {data.subgenres?.map((genre) => {
                                return genre.name
                            }).join(', ')}
                        </Grid.Col>
                        <Grid.Col span={4}>
                            <Text>Released in {data.release_year}</Text>
                            <Text>You have played it {data.times_played} times</Text>
                            <Text>You last played it on {data.last_played}</Text>
                        </Grid.Col>
                    </Grid>
                    <Button fullWidth mt="md" onClick={closeModal}>
                        Close modal
                    </Button>
                </>
            }
        </>
    );
};
export const DetailsModalWithProvider = ({closeModal, releaseId}) => {
    return (
        <QueryClientProvider client={queryClient}>
            <DetailsModal closeModal={closeModal} releaseId={releaseId}/>
        </QueryClientProvider>
    )
}
