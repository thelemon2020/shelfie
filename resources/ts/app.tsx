import React from 'react'
import * as ReactDOM from "react-dom/client";
import { AppShell, Navbar, Header } from '@mantine/core';

const root = ReactDOM.createRoot(document.getElementById('home-root'));
root.render(
    <AppShell
        padding="md"
        navbar={<Navbar width={{ base: 300 }} height={500} p="xs">{/* Navbar content */}</Navbar>}
        header={<Header height={60} p="xs">{/* Header content */}</Header>}
        styles={(theme) => ({
            main: { backgroundColor: theme.colorScheme === 'dark' ? theme.colors.dark[8] : theme.colors.gray[0] },
        })}
    >
        Hey YOU!
    </AppShell>
);
