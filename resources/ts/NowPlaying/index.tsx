import React from 'react';
import {Button, Card, Center, Group, Image, Text, useMantineTheme} from "@mantine/core";
import {QueryClient, QueryClientProvider, useQuery} from 'react-query'
import {Loader} from "tabler-icons-react";


const queryClient = new QueryClient();

export default function NowPlayingSection() {
    return (
        <QueryClientProvider client={queryClient}>
            <NowPlaying/>
        </QueryClientProvider>
    );
}

const NowPlaying = () => {
    const {isLoading, error, data} = useQuery('now-playing', () =>
        fetch('http://127.0.0.1:8000/api/release/nowplaying').then(res =>
            res.json()
        )
    )
    const theme = useMantineTheme();
    return (
        <div>
            {
                isLoading ?
                    <Center>
                        <Loader/>
                    </Center> :
                    <div>
                        {
                            data === null ? <Center><Card><Text>Nothing! Go Spin A Record!</Text></Card></Center> :
                                <Center>
                                    <Card shadow="sm" p="lg">
                                        <Card.Section>
                                            <Center>
                                                <Text>Now Playing</Text>
                                            </Center>
                                        </Card.Section>
                                        <Card.Section>
                                            <Center>
                                                <Image
                                                    src={data.full_image}
                                                    height={400} width={400} alt="Album Cover"/>
                                            </Center>
                                        </Card.Section>

                                        <Group position="apart" style={{marginBottom: 5, marginTop: theme.spacing.sm}}>
                                            <Text weight={500}>{data.artist}</Text>
                                            <Text weight={500}>{data.title}</Text>
                                        </Group>
                                        <Center>
                                            <Button variant="light" color="blue" fullWidth={false}
                                                    style={{marginTop: 14}}>
                                                View Details
                                            </Button>
                                        </Center>
                                    </Card>
                                </Center>
                        }</div>}
        </div>
    )
        ;
}
