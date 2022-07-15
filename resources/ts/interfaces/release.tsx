import React from 'react'

export interface Release {
    artist: string
    title: string
    id: number
    full_image: string
    genres: string[]
    subgenres: string[]
    last_played: string
    times_played: number
}
