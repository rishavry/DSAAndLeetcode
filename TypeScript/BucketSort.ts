// to run, use: npx ts-node TypeScript/BucketSort.ts
class BucketSort {
    sortArray(sortType: string, elementsToSort: number[], min: number, max: number): number[] {
        if (max == min) {
            return elementsToSort;
        }

        const numBuckets: number = elementsToSort.length;
        const buckets:number[][] = [];
        
        for(let i = 0; i<numBuckets; i++) {
            buckets.push([]);
        }

        for(let element of elementsToSort) {
            let index = Math.round((element - min) / (max - min) * numBuckets);
            buckets[index].push(element);
        }

        let sortedElements: number[] = [];

        for(let bucket of buckets) {
            bucket.sort();
            sortedElements = sortedElements.concat(bucket);
        }

        return sortedElements;
    }
}