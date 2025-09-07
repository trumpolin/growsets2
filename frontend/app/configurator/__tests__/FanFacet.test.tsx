import { render } from "@testing-library/react";
import FanFacet from "@/app/configurator/FanFacet";
import { useInfiniteQuery } from "@tanstack/react-query";
import { fetchCategoryArticles } from "@/lib/api";
import { useSelection } from "@/components/SelectionProvider";

jest.mock("@tanstack/react-query", () => ({
  useInfiniteQuery: jest.fn(),
}));

jest.mock("@/components/SelectionProvider", () => ({
  useSelection: jest.fn(),
}));

jest.mock("@/lib/api", () => ({
  fetchCategoryArticles: jest.fn(),
}));

describe("FanFacet", () => {
  it("fetches fan articles", () => {
    (useSelection as jest.Mock).mockReturnValue({
      selections: { fan: null },
      setSelection: jest.fn(),
    });
    (useInfiniteQuery as jest.Mock).mockReturnValue({
      data: { pages: [{ items: [] }] },
      fetchNextPage: jest.fn(),
      hasNextPage: false,
      isFetchingNextPage: false,
    });

    render(<FanFacet />);

    const options = (useInfiniteQuery as jest.Mock).mock.calls[0][0];
    expect(options.queryKey).toEqual(["fanArticles"]);
    options.queryFn({ pageParam: 1 });
    expect(fetchCategoryArticles).toHaveBeenCalledWith("fan", 1, 10, undefined);
  });
});
